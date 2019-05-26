<?php

namespace jeremykenedy\LaravelRoles\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Traits\RolesAndPermissionsHelpersTrait;
use jeremykenedy\LaravelRoles\Traits\RolesUsageAuthTrait;

class LaravelpermissionsDeletedController extends Controller
{
    use RolesUsageAuthTrait;
    use RolesAndPermissionsHelpersTrait;

    /**
     * Show the deleted permission items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deletedPermissions = $this->getDeletedPermissions()->get();
        $data = [
            'deletedPermissions' => $deletedPermissions,
        ];

// foreach ($deletedPermissions as $deletedPermission) {

// dd($deletedPermission->roles()->get());

// }

        return view('laravelroles::laravelroles.crud.permissions.deleted.index', $data);
    }
}
