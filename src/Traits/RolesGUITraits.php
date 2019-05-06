<?php

namespace jeremykenedy\LaravelRoles\Traits;

use Illuminate\Support\Facades\DB;

trait RolesGUITraits
{
    /**
     * Retrieves permission roles.
     *
     * @param Permission $permission               The permission
     * @param Collection $permissionsAndRolesPivot The permissions and roles pivot
     * @param Collection $sortedRolesWithUsers     The sorted roles with users
     *
     * @return Collection of permission roles
     */
    private function retrievePermissionRoles($permission, $permissionsAndRolesPivot, $sortedRolesWithUsers)
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
     *
     * @return Collection of Permission Users
     */
    private function retrievePermissionUsers($permission, $permissionsAndRolesPivot, $sortedRolesWithUsers)
    {
        $users = [];
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

        return collect($users);
    }

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
     * Gets the permissions.
     *
     * @return collection The permissions.
     */
    public function getPermissions()
    {
        return config('roles.models.permission')::all();
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
     * Gets the deleted roles.
     *
     * @return collection The deleted roles.
     */
    public function getDeletedRoles()
    {
        return config('roles.models.role')::onlyTrashed();
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
     * Gets the permissions with roles.
     *
     * @param collection $role The role
     *
     * @return collection The permissions with roles.
     */
    public function getPermissionsWithRoles($role = null)
    {
        $query = DB::table(config('roles.permissionsRoleTable'));
        if ($role) {
            $query->where('role_id', '=', $role->id);
        }

        return $query->get();
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
     *
     * @return collection The sorted permissons with roles and users.
     */
    public function getSortedPermissonsWithRolesAndUsers($sortedRolesWithUsers, $permissions)
    {
        $sortedPermissionsWithRoles = [];
        $permissionsAndRolesPivot = $this->getPermissionsWithRoles();

        foreach ($permissions as $permissionKey => $permissionValue) {
            $sortedPermissionsWithRoles[] = [
                'permission'    => $permissionValue,
                'roles'         => $this->retrievePermissionRoles($permissionValue, $permissionsAndRolesPivot, $sortedRolesWithUsers),
                'users'         => $this->retrievePermissionUsers($permissionValue, $permissionsAndRolesPivot, $sortedRolesWithUsers),
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
        $users                  = $this->getUsers();
        $roles                  = $this->getRoles();
        $sortedRolesWithUsers   = $this->getSortedUsersWithRoles($roles, $users);
        $roleUsers              = [];

        // Remove Users Attached to Role
        foreach ($sortedRolesWithUsers as $sortedRolesWithUsersKey => $sortedRolesWithUsersValue) {
            if ($sortedRolesWithUsersValue['role'] == $role) {
                $roleUsers[] = $sortedRolesWithUsersValue['users'];
            }
        }
        foreach ($roleUsers as $roleUserKey => $roleUserValue) {
            if(!empty($roleUserValue)) {
                $roleUserValue[$roleUserKey]->detachRole($role);
            }
        }

        // Remove Permissions from Role
        $role->detachAllPermissions();
    }

}
