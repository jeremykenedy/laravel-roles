<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Http\Controllers\Api;

use jeremykenedy\LaravelRoles\App\Http\Controllers\Controller;
use jeremykenedy\LaravelRoles\App\Http\Requests\StoreRoleRequest;
use jeremykenedy\LaravelRoles\Traits\RolesAndPermissionsHelpersTrait;
use Illuminate\Http\JsonResponse;

class LaravelRolesApiController extends Controller
{
    use RolesAndPermissionsHelpersTrait;

    /**
     * Return all the roles, Permissions, and Users data.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->getDashboardData();

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'Success returning all roles and permissions data.',
            'data'      => $data['data'],
        ], 200);
    }

    /**
     * Store a newly created role.
     *
     *
     * @return JsonResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $roleData = $request->roleFillData();
        $rolePermissions = $request->get('permissions');
        $role = $this->storeRoleWithPermissions($roleData, $rolePermissions);

        return response()->json([
            'code'      => 201,
            'status'    => 'created',
            'message'   => 'Success created new role.',
            'role'      => $role,
        ], 201);
    }
}
