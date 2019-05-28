<?php

namespace jeremykenedy\LaravelRoles\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\App\Http\Requests\StorePermissionRequest;
use jeremykenedy\LaravelRoles\App\Http\Requests\UpdatePermissionRequest;
use jeremykenedy\LaravelRoles\App\Services\PermissionFormFields;
use jeremykenedy\LaravelRoles\Traits\RolesAndPermissionsHelpersTrait;
use jeremykenedy\LaravelRoles\Traits\RolesUsageAuthTrait;

class LaravelPermissionsController extends Controller
{
    use RolesAndPermissionsHelpersTrait;
    use RolesUsageAuthTrait;

    /**
     * Show the roles and Permissions dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->getDashboardData();

        return view($data['view'], $data['data']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service = new PermissionFormFields();
        $data = $service->handle();

        return view('laravelroles::laravelroles.crud.permissions.create', $data);
    }

    /**
     * Store a newly created permission in storage.
     *
     * @param \jeremykenedy\LaravelRoles\App\Http\Requests\StorePermissionRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        $permissionData = $request->permissionFillData();
        $permission = $this->storeNewPermission($permissionData);

        return redirect()->route('laravelroles::roles.index')
                            ->with('success', trans('laravelroles::laravelroles.flash-messages.permission-create', ['permission' => $permission->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->getPermissionItemData($id);

        return view('laravelroles::laravelroles.crud.permissions.show', $data);
    }

    /**
     * Edit the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $service = new PermissionFormFields($id);
        $data = $service->handle();

        return view('laravelroles::laravelroles.crud.permissions.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \jeremykenedy\LaravelRoles\App\Http\Requests\UpdatePermissionRequest $request
     * @param int                                                                  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        $permissionData = $request->permissionFillData($id);
        $permission = $this->updatePermission($id, $permissionData);

        return redirect()->route('laravelroles::roles.index')
            ->with('success', trans('laravelroles::laravelroles.flash-messages.permission-updated', ['permission' => $permission->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = $this->deletePermission($id);

        return redirect(route('laravelroles::roles.index'))
                    ->with('success', trans('laravelroles::laravelroles.flash-messages.successDeletedItem', ['type' => 'Permission', 'item' => $permission->name]));
    }
}
