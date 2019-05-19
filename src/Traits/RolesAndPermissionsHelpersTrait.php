<?php

namespace jeremykenedy\LaravelRoles\Traits;

use Illuminate\Support\Facades\DB;

trait RolesAndPermissionsHelpersTrait
{
    /**
     * Gets the roles.
     *
     * @return collection The roles.
     */
    public function getRoles()
    {
        return config('roles.models.role')::all();
    }

    /**
     * Gets the role.
     *
     * @param int $id The identifier
     *
     * @return collection The role.
     */
    public function getRole($id)
    {
        return config('roles.models.role')::findOrFail($id);
    }

    /**
     * Gets the permissions.
     *
     * @return collection The permissions.
     */
    public function getPermissions()
    {
        return config('roles.models.permission')::all();
    }

    /**
     * Gets the permission.
     *
     * @param int $id The identifier
     *
     * @return collection The permission.
     */
    public function getPermission($id)
    {
        return config('roles.models.permission')::findOrFail($id);
    }

    /**
     * Gets the users.
     *
     * @return collection The users.
     */
    public function getUsers()
    {
        return config('roles.models.defaultUser')::all();
    }

    /**
     * Gets the user.
     *
     * @param int $id The user id
     *
     * @return User The user.
     */
    public function getUser($id)
    {
        return config('roles.models.defaultUser')::findOrFail($id);
    }

    /**
     * Gets the deleted roles.
     *
     * @return collection The deleted roles.
     */
    public function getDeletedRoles()
    {
        return config('roles.models.role')::onlyTrashed();
    }

    /**
     * Gets the deleted permissions.
     *
     * @return collection The deleted permissions.
     */
    public function getDeletedPermissions()
    {
        return config('roles.models.permission')::onlyTrashed();
    }

    /**
     * Gets the permissions with roles.
     *
     * @param int $roleId The role Id
     *
     * @return collection The permissions with roles.
     */
    public function getPermissionsWithRoles($roleId = null)
    {
        $query = DB::table(config('roles.permissionsRoleTable'));
        if ($roleId) {
            $query->where('role_id', '=', $roleId);
        }

        return $query->get();
    }

    /**
     * Gets the permission users.
     *
     * @param int $permissionId The permission identifier
     *
     * @return Collection The permission users.
     */
    public function getPermissionUsers($permissionId = null)
    {
        $query = DB::table(config('roles.permissionsUserTable'));
        if ($permissionId) {
            $query->where('permission_id', '=', $permissionId);
        }

        return $query->get();
    }

    /**
     * Gets the permission models.
     *
     * @return The permission models.
     */
    public function getPermissionModels()
    {
        $permissionModel = config('roles.models.permission');

        return DB::table(config('roles.permissionsTable'))->pluck('model')->merge(collect(class_basename(new $permissionModel())))->unique();
    }

    /**
     * Gets the role permissions.
     *
     * @param int $id The Role Id
     *
     * @return array The role permissions.
     */
    public function getRolePermissions($id)
    {
        $permissionPivots = $this->getPermissionsWithRoles($id);
        $permissions = [];

        if (count($permissionPivots) != 0) {
            foreach ($permissionPivots as $permissionPivot) {
                $permissions[] = $this->getPermission($permissionPivot->permission_id);
            }
        }

        return collect($permissions);
    }

    /**
     * Gets the role permissions identifiers.
     *
     * @param int $id The Role Id
     *
     * @return array The role permissions Ids.
     */
    public function getRolePermissionsIds($id)
    {
        $permissionPivots = $this->getPermissionsWithRoles($id);
        $permissionIds = [];

        if (count($permissionPivots) != 0) {
            foreach ($permissionPivots as $permissionPivot) {
                $permissionIds[] = $permissionPivot->permission_id;
            }
        }

        return $permissionIds;
    }

    /**
     * Gets the permission item data.
     *
     * @param int $id The Permission ID
     *
     * @return array The Permission item data.
     */
    public function getPermissionItemData($id)
    {
        $permission = config('roles.models.permission')::findOrFail($id);
        $users = $this->getUsers();
        $roles = $this->getRoles();
        $permissions = $this->getPermissions();
        $sortedRolesWithUsers = $this->getSortedUsersWithRoles($roles, $users);
        $sortedPermissionsRolesUsers = $this->getSortedPermissonsWithRolesAndUsers($sortedRolesWithUsers, $permissions, $users);

        $data = [];

        foreach ($sortedPermissionsRolesUsers as $item) {
            if ($item['permission']->id === $permission->id) {
                $data = [
                    'item' => $item,
                ];
            }
        }

        return $data;
    }

    /**
     * Gets the dashboard data.
     *
     * @return array The dashboard data and view.
     */
    public function getDashboardData()
    {
        $roles = $this->getRoles();
        $permissions = $this->getPermissions();
        $deletedRoleItems = $this->getDeletedRoles();
        $deletedPermissionsItems = $this->getDeletedPermissions();
        $users = $this->getUsers();
        $sortedRolesWithUsers = $this->getSortedUsersWithRoles($roles, $users);
        $sortedRolesWithPermissionsAndUsers = $this->getSortedRolesWithPermissionsAndUsers($sortedRolesWithUsers, $permissions);
        $sortedPermissionsRolesUsers = $this->getSortedPermissonsWithRolesAndUsers($sortedRolesWithUsers, $permissions, $users);

        $data = [
            'roles'                              => $roles,
            'permissions'                        => $permissions,
            'deletedRoleItems'                   => $deletedRoleItems,
            'deletedPermissionsItems'            => $deletedPermissionsItems,
            'users'                              => $users,
            'sortedRolesWithUsers'               => $sortedRolesWithUsers,
            'sortedRolesWithPermissionsAndUsers' => $sortedRolesWithPermissionsAndUsers,
            'sortedPermissionsRolesUsers'        => $sortedPermissionsRolesUsers,
        ];

        $view = 'laravelroles::laravelroles.crud.dashboard';

        $data = [
            'data' => $data,
            'view' => $view,
        ];

        return $data;
    }

    /**
     * Retrieves permission roles.
     *
     * @param Permission $permission               The permission
     * @param Collection $permissionsAndRolesPivot The permissions and roles pivot
     * @param Collection $sortedRolesWithUsers     The sorted roles with users
     *
     * @return Collection of permission roles
     */
    public function retrievePermissionRoles($permission, $permissionsAndRolesPivot, $sortedRolesWithUsers)
    {
        $roles = [];
        foreach ($permissionsAndRolesPivot as $permissionAndRoleKey => $permissionAndRoleValue) {
            if ($permission->id === $permissionAndRoleValue->permission_id) {
                foreach ($sortedRolesWithUsers as $sortedRolesWithUsersItemKey => $sortedRolesWithUsersItemValue) {
                    if ($sortedRolesWithUsersItemValue['role']->id === $permissionAndRoleValue->role_id) {
                        $roles[] = $sortedRolesWithUsersItemValue['role'];
                    }
                }
            }
        }

        return collect($roles);
    }

    /**
     * Retrieves permission users.
     *
     * @param Permission $permission               The permission
     * @param Collection $permissionsAndRolesPivot The permissions and roles pivot
     * @param Collection $sortedRolesWithUsers     The sorted roles with users
     * @param Collection $permissionUsersPivot     The permission users pivot
     * @param Collection $users                    The users
     *
     * @return Collection of Permission Users
     */
    public function retrievePermissionUsers($permission, $permissionsAndRolesPivot, $sortedRolesWithUsers, $permissionUsersPivot, $appUsers)
    {
        $users = [];
        $userIds = [];

        // Get Users from permissions associated with roles
        foreach ($permissionsAndRolesPivot as $permissionsAndRolesPivotItemKey => $permissionsAndRolesPivotItemValue) {
            if ($permission->id === $permissionsAndRolesPivotItemValue->permission_id) {
                foreach ($sortedRolesWithUsers as $sortedRolesWithUsersItemKey => $sortedRolesWithUsersItemValue) {
                    if ($permissionsAndRolesPivotItemValue->role_id === $sortedRolesWithUsersItemValue['role']->id) {
                        foreach ($sortedRolesWithUsersItemValue['users'] as $sortedRolesWithUsersItemValueUser) {
                            $users[] = $sortedRolesWithUsersItemValueUser;
                        }
                    }
                }
            }
        }

        // Setup Users IDs from permissions associated with roles
        foreach ($users as $userKey => $userValue) {
            $userIds[] = $userValue->id;
        }

        // Get Users from permissions pivot table that are not already in users from permissions associated with roles
        foreach ($permissionUsersPivot as $permissionUsersPivotKey => $permissionUsersPivotItem) {
            if (!in_array($permissionUsersPivotItem->user_id, $userIds) && $permission->id === $permissionUsersPivotItem->permission_id) {
                foreach ($appUsers as $appUser) {
                    if ($appUser->id === $permissionUsersPivotItem->user_id) {
                        $users[] = $appUser;
                    }
                }
            }
        }

        return collect($users);
    }

    /**
     * Gets the sorted users with roles.
     *
     * @param collection $roles The roles
     * @param collection $users The users
     *
     * @return collection The sorted users with roles.
     */
    public function getSortedUsersWithRoles($roles, $users)
    {
        $sortedUsersWithRoles = [];

        foreach ($roles as $rolekey => $roleValue) {
            $sortedUsersWithRoles[] = [
                'role'   => $roleValue,
                'users'  => [],
            ];
            foreach ($users as $user) {
                foreach ($user->roles as $userRole) {
                    if ($userRole->id === $sortedUsersWithRoles[$rolekey]['role']['id']) {
                        $sortedUsersWithRoles[$rolekey]['users'][] = $user;
                    }
                }
            }
        }

        return collect($sortedUsersWithRoles);
    }

    /**
     * Gets the sorted roles with permissions.
     *
     * @param collection $sortedRolesWithUsers The sorted roles with users
     * @param collection $permissions          The permissions
     *
     * @return collection The sorted roles with permissions.
     */
    public function getSortedRolesWithPermissionsAndUsers($sortedRolesWithUsers, $permissions)
    {
        $sortedRolesWithPermissions = [];
        $permissionsAndRoles = $this->getPermissionsWithRoles();

        foreach ($sortedRolesWithUsers as $sortedRolekey => $sortedRoleValue) {
            $role = $sortedRoleValue['role'];
            $users = $sortedRoleValue['users'];
            $sortedRolesWithPermissions[] = [
                'role'          => $role,
                'permissions'   => collect([]),
                'users'         => collect([]),
            ];

            // Add Permission with Role
            foreach ($permissionsAndRoles as $permissionAndRole) {
                if ($permissionAndRole->role_id == $role->id) {
                    foreach ($permissions as $permissionKey => $permissionValue) {
                        if ($permissionValue->id == $permissionAndRole->permission_id) {
                            $sortedRolesWithPermissions[$sortedRolekey]['permissions'][] = $permissionValue;
                        }
                    }
                }
            }

            // Add Users with Role
            foreach ($users as $user) {
                foreach ($user->roles as $userRole) {
                    if ($userRole->id === $sortedRolesWithPermissions[$sortedRolekey]['role']['id']) {
                        $sortedRolesWithPermissions[$sortedRolekey]['users'][] = $user;
                    }
                }
            }
        }

        return collect($sortedRolesWithPermissions);
    }

    /**
     * Gets the sorted permissons with roles and users.
     *
     * @param collection $sortedRolesWithUsers The sorted roles with users
     * @param collection $permissions          The permissions
     * @param colection  $users                The users
     *
     * @return collection The sorted permissons with roles and users.
     */
    public function getSortedPermissonsWithRolesAndUsers($sortedRolesWithUsers, $permissions, $users)
    {
        $sortedPermissionsWithRoles = [];
        $permissionsAndRolesPivot = $this->getPermissionsWithRoles();
        $permissionUsersPivot = $this->getPermissionUsers();

        foreach ($permissions as $permissionKey => $permissionValue) {
            $sortedPermissionsWithRoles[] = [
                'permission'    => $permissionValue,
                'roles'         => $this->retrievePermissionRoles($permissionValue, $permissionsAndRolesPivot, $sortedRolesWithUsers),
                'users'         => $this->retrievePermissionUsers($permissionValue, $permissionsAndRolesPivot, $sortedRolesWithUsers, $permissionUsersPivot, $users),
            ];
        }

        return collect($sortedPermissionsWithRoles);
    }

    /**
     * Removes an users and permissions from role.
     *
     * @param Role$role   The role
     *
     * @return void
     */
    public function removeUsersAndPermissionsFromRole($role)
    {
        $users = $this->getUsers();
        $roles = $this->getRoles();
        $sortedRolesWithUsers = $this->getSortedUsersWithRoles($roles, $users);
        $roleUsers = [];

        // Remove Users Attached to Role
        foreach ($sortedRolesWithUsers as $sortedRolesWithUsersKey => $sortedRolesWithUsersValue) {
            if ($sortedRolesWithUsersValue['role'] == $role) {
                $roleUsers[] = $sortedRolesWithUsersValue['users'];
            }
        }
        foreach ($roleUsers as $roleUserKey => $roleUserValue) {
            if (!empty($roleUserValue)) {
                $roleUserValue[$roleUserKey]->detachRole($role);
            }
        }

        // Remove Permissions from Role
        $role->detachAllPermissions();
    }

    /**
     * Removes an users and permissions from permission.
     *
     * @param Permission $permission The Permission
     *
     * @return void
     */
    public function removeUsersAndRolesFromPermissions($permission)
    {
        $users = $this->getUsers();
        $roles = $this->getRoles();
        $permissions = $this->getPermissions();
        $sortedRolesWithUsers = $this->getSortedUsersWithRoles($roles, $users);
        $sortedPermissionsRolesUsers = $this->getSortedPermissonsWithRolesAndUsers($sortedRolesWithUsers, $permissions, $users);

        foreach ($sortedPermissionsRolesUsers as $sortedPermissionsRolesUsersKey => $sortedPermissionsRolesUsersItem) {
            if ($sortedPermissionsRolesUsersItem['permission']->id === $permission->id) {

                // Remove Permission from roles
                foreach ($sortedPermissionsRolesUsersItem['roles'] as $permissionRoleKey => $permissionRoleItem) {
                    $permissionRoleItem->detachPermission($permission);
                }

                // Permission Permission from Users
                foreach ($sortedPermissionsRolesUsersItem['users'] as $permissionUserKey => $permissionUserItem) {
                    $permissionUserItem->detachPermission($permission);
                }
            }
        }
    }

    /**
     * Stores role with permissions.
     *
     * @param array  $roleData        The role data
     * @param object $rolePermissions The role permissions
     *
     * @return collection The Role
     */
    public function storeRoleWithPermissions($roleData, $rolePermissions)
    {
        $role = config('roles.models.role')::create($roleData);

        if ($rolePermissions) {
            $permissionIds = [];
            foreach ($rolePermissions as $permission) {
                $permissionIds[] = json_decode($permission)->id;
            }
            $role->syncPermissions($permissionIds);
        }

        return $role;
    }

    /**
     * Update Role with permissions.
     *
     * @param int    $id              The identifier
     * @param array  $roleData        The role data
     * @param object $rolePermissions The role permissions
     *
     * @return collection The Role
     */
    public function updateRoleWithPermissions($id, $roleData, $rolePermissions)
    {
        $role = config('roles.models.role')::findOrFail($id);

        $role->fill($roleData);
        $role->save();
        $role->detachAllPermissions();

        if ($rolePermissions) {
            $permissionIds = [];
            foreach ($rolePermissions as $permission) {
                $permissionIds[] = json_decode($permission)->id;
            }
            $role->syncPermissions($permissionIds);
        }

        return $role;
    }

    /**
     * Stores a new permission.
     *
     * @param array $permissionData The permission data
     *
     * @return collection The New Permission
     */
    public function storeNewPermission($permissionData)
    {
        return config('roles.models.permission')::create($permissionData);
    }

    /**
     * Update a permission.
     *
     * @param int   $id             The identifier
     * @param array $permissionData The permission data
     *
     * @return collection
     */
    public function updatePermission($id, $permissionData)
    {
        $permission = config('roles.models.permission')::findOrFail($id);
        $permission->fill($permissionData);
        $permission->save();

        return $permission;
    }

    /**
     * Delete a role.
     *
     * @param int $id The identifier
     *
     * @return collection
     */
    public function deleteRole($id)
    {
        $role = $this->getRole($id);
        $this->removeUsersAndPermissionsFromRole($role);
        $role->delete();

        return $role;
    }
}
