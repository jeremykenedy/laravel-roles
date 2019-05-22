<?php

namespace jeremykenedy\LaravelRoles\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\App\Http\Requests\StoreRoleRequest;
use jeremykenedy\LaravelRoles\App\Http\Requests\UpdateRoleRequest;
use jeremykenedy\LaravelRoles\App\Services\RoleFormFields;
use jeremykenedy\LaravelRoles\Traits\RolesAndPermissionsHelpersTrait;

class LaravelRolesDeletedController extends Controller
{
    use RolesAndPermissionsHelpersTrait;

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
        $this->_rolesGuiAuthEnabled = config('roles.rolesGuiAuthEnabled');
        $this->_rolesGuiMiddlewareEnabled = config('roles.rolesGuiMiddlewareEnabled');
        $this->_rolesGuiMiddleware = config('roles.rolesGuiMiddleware');

        if ($this->_rolesGuiAuthEnabled) {
            $this->middleware('auth');
        }

        if ($this->_rolesGuiMiddlewareEnabled) {
            $this->middleware($this->_rolesGuiMiddleware);
        }
    }




    /**
     * Show the deleted role items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {




        // $roles = $this->getRoles();
        // $permissions = $this->getPermissions();
        // $deletedRoleItems = $this->getDeletedRoles();
        // $deletedPermissionsItems = $this->getDeletedPermissions();
        // $users = $this->getUsers();
        // $sortedRolesWithUsers = $this->getSortedUsersWithRoles($roles, $users);
        // $sortedRolesWithPermissionsAndUsers = $this->getSortedRolesWithPermissionsAndUsers($sortedRolesWithUsers, $permissions);
        // $sortedPermissionsRolesUsers = $this->getSortedPermissonsWithRolesAndUsers($sortedRolesWithUsers, $permissions, $users);

        // $data = [
        //     'roles'                              => $roles,
        //     'permissions'                        => $permissions,
        //     'deletedRoleItems'                   => $deletedRoleItems,
        //     'deletedPermissionsItems'            => $deletedPermissionsItems,
        //     'users'                              => $users,
        //     'sortedRolesWithUsers'               => $sortedRolesWithUsers,
        //     'sortedRolesWithPermissionsAndUsers' => $sortedRolesWithPermissionsAndUsers,
        //     'sortedPermissionsRolesUsers'        => $sortedPermissionsRolesUsers,
        // ];

        // $view = 'laravelroles::laravelroles.crud.dashboard';

        // $data = [
        //     'data' => $data,
        //     'view' => $view,
        // ];

        // return $data;



        // if (config('laravelblocker.blockerPaginationEnabled')) {
        //     $roles = BlockedItem::onlyTrashed()->paginate(config('laravelblocker.blockerPaginationPerPage'));
        // } else {
        //     $roles = BlockedItem::onlyTrashed()->get();
        // }

// $roles              = config('roles.models.role')::onlyTrashed()->get();
// $permissions        = $this->getPermissions();

$deletedRoleItems           = $this->getDeletedRoles()->get();
// $deletedPermissionsItems    = $this->getDeletedPermissions();
// $users                      = $this->getUsers();
// $sortedRolesWithUsers       = $this->getSortedUsersWithRoles($deletedRoleItems, $users);

// dd($deletedRoleItems);
// dd($deletedRoleItems);

// foreach ($deletedRoleItems as $deletedRoleItem) {

//     dd($deletedRoleItem->permissions()->get());

// }

// laravelroles::roles-deleted

$data = [
    'deletedRoleItems' => $deletedRoleItems,
];

return view('laravelroles::laravelroles.crud.roles.deleted.index', $data);

// return view($data['view'], $data['data']);

    }




}

