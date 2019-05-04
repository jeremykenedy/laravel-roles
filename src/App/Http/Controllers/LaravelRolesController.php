<?php

namespace jeremykenedy\LaravelRoles\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use jeremykenedy\LaravelRoles\Traits\RolesGUITraits;

class LaravelRolesController extends Controller
{
    use RolesGUITraits;

    private $_rolesGuiAuthEnabled;
    private $_rolesGuiMiddlewareEnabled;
    private $_rolesGuiMiddleware;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_rolesGuiAuthEnabled         = config('roles.rolesGuiAuthEnabled');
        $this->_rolesGuiMiddlewareEnabled   = config('roles.rolesGuiMiddlewareEnabled');
        $this->_rolesGuiMiddleware          = config('roles.rolesGuiMiddleware');

        if ($this->_rolesGuiAuthEnabled) {
            $this->middleware('auth');
        }

        if ($this->_rolesGuiMiddlewareEnabled) {
            $this->middleware($this->_rolesGuiMiddleware);
        }
    }

    /**
     * Show the roles and Permissions dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles                              = $this->getRoles();
        $permissions                        = $this->getPermissions();
        $deletedRoleItems                   = $this->getDeletedRoles();
        $users                              = $this->getUsers();
        $sortedRolesWithUsers               = $this->getSortedUsersWithRoles($roles, $users);
        $sortedRolesWithPermissionsAndUsers = $this->getSortedRolesWithPermissionsAndUsers($sortedRolesWithUsers, $permissions);
        $sortedPermissionsRolesUsers        = $this->getSortedPermissonsWithRolesAndUsers($sortedRolesWithUsers, $permissions);

        $data = [
            'roles',
            'permissions',
            'deletedRoleItems',
            'users',
            'sortedRolesWithUsers',
            'sortedRolesWithPermissionsAndUsers',
            'sortedPermissionsRolesUsers',
        ];

        return view('laravelroles::laravelroles.crud.dashboard', compact($data));
    }

}
