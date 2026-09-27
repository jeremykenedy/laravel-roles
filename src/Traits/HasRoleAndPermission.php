<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\Traits;

use BadMethodCallException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use InvalidArgumentException;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use ReflectionMethod;

trait HasRoleAndPermission
{
    /**
     * Property for caching roles.
     *
     * @var Collection|null
     */
    protected $roles;

    /**
     * Property for caching permissions.
     *
     * @var Collection|null
     */
    protected $permissions;

    /**
     * User belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('roles.models.role'), config('roles.roleUserTable'))->withTimestamps();
    }

    /**
     * Get all roles as collection.
     *
     * @return Collection
     */
    public function getRoles()
    {
        if (!$this->roles) {
            if (method_exists($this, 'loadMissing')) {
                $this->loadMissing('roles');
            } else {
                if (!array_key_exists('roles', $this->relations)) {
                    $this->load('roles');
                }
            }
            if (method_exists($this, 'getRelation')) {
                $this->roles = $this->getRelation('roles');
            } else {
                $this->roles = $this->relations['roles'];
            }
        }

        return $this->roles;
    }

    /**
     * Check if the user has a role or roles.
     *
     * @param int|string|array $role
     * @param bool             $all
     *
     * @return bool
     */
    public function hasRole($role, $all = false)
    {
        if ($this->isPretendEnabled()) {
            return $this->pretend('hasRole');
        }

        if (!$all) {
            return $this->hasOneRole($role);
        }

        return $this->hasAllRoles($role);
    }

    /**
     * Check if the user has at least one of the given roles.
     *
     * @param int|string|array $role
     *
     * @return bool
     */
    public function hasOneRole($role)
    {
        foreach ($this->getArrayFrom($role) as $role) {
            if ($this->checkRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has all roles.
     *
     * @param int|string|array $role
     *
     * @return bool
     */
    public function hasAllRoles($role)
    {
        foreach ($this->getArrayFrom($role) as $role) {
            if (!$this->checkRole($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the user has role.
     *
     * @param int|string $role
     *
     * @return bool
     */
    public function checkRole($role)
    {
        return $this->getRoles()->contains(function ($value) use ($role) {
            return $role == $value->id || Str::is($role, $value->slug);
        });
    }

    /**
     * Attach role to a user.
     *
     * @param int|Role $role
     *
     * @return null|bool
     */
    public function attachRole($role)
    {
        if ($this->getRoles()->contains($role)) {
            return true;
        }
        $this->resetRoles();

        return $this->roles()->attach($role);
    }

    /**
     * Detach role from a user.
     *
     * @param int|Role $role
     *
     * @return int
     */
    public function detachRole($role)
    {
        $this->resetRoles();

        return $this->roles()->detach($role);
    }

    /**
     * Detach all roles from a user.
     *
     * @return int
     */
    public function detachAllRoles()
    {
        $this->resetRoles();

        return $this->roles()->detach();
    }

    /**
     * Sync roles for a user.
     *
     * @param array|Role[]|Collection $roles
     *
     * @return array
     */
    public function syncRoles($roles)
    {
        $this->resetRoles();

        return $this->roles()->sync($roles);
    }

    /**
     * Get role level of a user.
     *
     * @return int
     */
    public function level()
    {
        return ($role = $this->getRoles()->sortByDesc('level')->first()) ? $role->level : 0;
    }

    /**
     * Get all permissions from roles.
     *
     * @return Builder
     */
    public function rolePermissions()
    {
        $permissionModel = app(config('roles.models.permission'));
        $permissionTable = config('roles.permissionsTable');
        $permissionRoleTable = config('roles.permissionsRoleTable');
        $roleTable = config('roles.rolesTable');

        if (!$permissionModel instanceof Model) {
            throw new InvalidArgumentException('[roles.models.permission] must be an instance of \Illuminate\Database\Eloquent\Model');
        }

        $query = $permissionModel::select([
            $permissionTable.'.*',
            $permissionRoleTable.'.created_at as pivot_created_at',
            $permissionRoleTable.'.updated_at as pivot_updated_at',
        ])
            ->join($permissionRoleTable, $permissionRoleTable.'.permission_id', '=', $permissionTable.'.id')
            ->join($roleTable, $roleTable.'.id', '=', $permissionRoleTable.'.role_id')
            ->whereNull($roleTable.'.deleted_at')
            ->whereIn($roleTable.'.id', $this->getRoles()->pluck('id')->toArray());

        if (config('roles.inheritance')) {
            $query->orWhere(function ($query) use ($roleTable) {
                $query->where($roleTable.'.level', '<', $this->level())
                    ->whereNull($roleTable.'.deleted_at');
            });
        }

        return $query->groupBy([
            $permissionTable.'.id',
            $permissionTable.'.name',
            $permissionTable.'.slug',
            $permissionTable.'.description',
            $permissionTable.'.model',
            $permissionTable.'.created_at',
            $permissionTable.'.updated_at',
            $permissionTable.'.deleted_at',
            'pivot_created_at',
            'pivot_updated_at',
        ]);
    }

    /**
     * User belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function userPermissions()
    {
        return $this->belongsToMany(config('roles.models.permission'), config('roles.permissionsUserTable'))->withTimestamps();
    }

    /**
     * Get all permissions as collection.
     *
     * @return Collection
     */
    public function getPermissions()
    {
        if ($this->permissions) {
            return $this->permissions;
        }

        $userPermissions = $this->relationLoaded('userPermissions')
            ? $this->getRelation('userPermissions')
            : $this->userPermissions()->get();

        return $this->permissions = $this->rolePermissions()->get()->merge($userPermissions);
    }

    /**
     * Check if the user has a permission or permissions.
     *
     * @param int|string|array $permission
     * @param bool             $all
     *
     * @return bool
     */
    public function hasPermission($permission, $all = false)
    {
        if ($this->isPretendEnabled()) {
            return $this->pretend('hasPermission');
        }

        if (!$all) {
            return $this->hasOnePermission($permission);
        }

        return $this->hasAllPermissions($permission);
    }

    /**
     * Check if the user has at least one of the given permissions.
     *
     * @param int|string|array $permission
     *
     * @return bool
     */
    public function hasOnePermission($permission)
    {
        foreach ($this->getArrayFrom($permission) as $permission) {
            if ($this->checkPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has all permissions.
     *
     * @param int|string|array $permission
     *
     * @return bool
     */
    public function hasAllPermissions($permission)
    {
        foreach ($this->getArrayFrom($permission) as $permission) {
            if (!$this->checkPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the user has a permission.
     *
     * @param int|string $permission
     *
     * @return bool
     */
    public function checkPermission($permission)
    {
        return $this->getPermissions()->contains(function ($value) use ($permission) {
            return $permission == $value->id || Str::is($permission, $value->slug);
        });
    }

    /**
     * Check if the user is allowed to manipulate with entity.
     *
     * @param string $providedPermission
     * @param bool   $owner
     * @param string $ownerColumn
     *
     * @return bool
     */
    public function allowed($providedPermission, Model $entity, $owner = true, $ownerColumn = 'user_id')
    {
        if ($this->isPretendEnabled()) {
            return $this->pretend('allowed');
        }

        if ($owner === true && $entity->{$ownerColumn} == $this->id) {
            return true;
        }

        return $this->isAllowed($providedPermission, $entity);
    }

    /**
     * Check if the user is allowed to manipulate with provided entity.
     *
     * @param string $providedPermission
     *
     * @return bool
     */
    protected function isAllowed($providedPermission, Model $entity)
    {
        foreach ($this->getPermissions() as $permission) {
            if ($permission->model != '' && get_class($entity) == $permission->model
                && ($permission->id == $providedPermission || $permission->slug === $providedPermission)
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Attach permission to a user.
     *
     * @param int|Permission $permission
     *
     * @return null|bool
     */
    public function attachPermission($permission)
    {
        if ($this->getPermissions()->contains($permission)) {
            return true;
        }
        $this->resetPermissions();

        return $this->userPermissions()->attach($permission);
    }

    /**
     * Detach permission from a user.
     *
     * @param int|Permission $permission
     *
     * @return int
     */
    public function detachPermission($permission)
    {
        $this->resetPermissions();

        return $this->userPermissions()->detach($permission);
    }

    /**
     * Detach all permissions from a user.
     *
     * @return int
     */
    public function detachAllPermissions()
    {
        $this->resetPermissions();

        return $this->userPermissions()->detach();
    }

    /**
     * Sync permissions for a user.
     *
     * @param array|Permission[]|Collection $permissions
     *
     * @return array
     */
    public function syncPermissions($permissions)
    {
        $this->resetPermissions();

        return $this->userPermissions()->sync($permissions);
    }

    /**
     * Check if pretend option is enabled.
     *
     * @return bool
     */
    private function isPretendEnabled()
    {
        return (bool) config('roles.pretend.enabled');
    }

    /**
     * Allows to pretend or simulate package behavior.
     *
     * @param string $option
     *
     * @return bool
     */
    private function pretend($option)
    {
        return (bool) config('roles.pretend.options.'.$option);
    }

    /**
     * Get an array from argument.
     *
     * @param int|string|array $argument
     *
     * @return array
     */
    private function getArrayFrom($argument)
    {
        return (!is_array($argument)) ? preg_split('/ ?[,|] ?/', (string) $argument) : $argument;
    }

    protected function resetRoles()
    {
        $this->roles = null;
        if (method_exists($this, 'unsetRelation')) {
            $this->unsetRelation('roles');
        } else {
            unset($this->relations['roles']);
        }
    }

    protected function resetPermissions()
    {
        $this->permissions = null;
        if (method_exists($this, 'unsetRelation')) {
            $this->unsetRelation('userPermissions');
        } else {
            unset($this->relations['userPermissions']);
        }
    }

    public function callMagic($method, $parameters)
    {
        if (Str::startsWith($method, 'is')) {
            return $this->hasRole(Str::snake(substr($method, 2), config('roles.separator')));
        } elseif (Str::startsWith($method, 'can')) {
            return $this->hasPermission(Str::snake(substr($method, 3), config('roles.separator')));
        } elseif (Str::startsWith($method, 'allowed')) {
            $permission = Str::snake(substr($method, 7), config('roles.separator'));
            $entity = $parameters[0] ?? null;
            $owner = $parameters[1] ?? true;
            $ownerColumn = $parameters[2] ?? 'user_id';

            if (!$entity instanceof Model) {
                throw new InvalidArgumentException('Entity must be an instance of '.Model::class);
            }

            return $this->allowed($permission, $entity, $owner, $ownerColumn);
        }

        // For traits, we cannot use parent::__call() directly
        // Try to call parent's __call if it exists using reflection
        $parentClass = get_parent_class($this);
        if ($parentClass && method_exists($parentClass, '__call')) {
            $reflection = new ReflectionMethod($parentClass, '__call');

            return $reflection->invoke($this, $method, $parameters);
        }

        throw new BadMethodCallException("Method [{$method}] does not exist.");
    }

    public function __call($method, $parameters)
    {
        return $this->callMagic($method, $parameters);
    }
}
