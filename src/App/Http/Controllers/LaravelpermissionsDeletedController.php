<?php

namespace jeremykenedy\LaravelRoles\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use jeremykenedy\LaravelRoles\Traits\RolesAndPermissionsHelpersTrait;
use jeremykenedy\LaravelRoles\Traits\RolesUsageAuthTrait;

class LaravelpermissionsDeletedController extends Controller
{
    use RolesAndPermissionsHelpersTrait;
    use RolesUsageAuthTrait;

    /**
     * Show the deleted permission items.
     *
     * @return Response
     */
    public function index()
    {
        $deletedPermissions = $this->getDeletedPermissions()->get();
        $data = [
            'deletedPermissions' => $deletedPermissions,
        ];

        return view('laravelroles::laravelroles.crud.permissions.deleted.index', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $item = $this->getDeletedPermissionAndDetails($id);
        $typeDeleted = 'deleted';

        return view('laravelroles::laravelroles.crud.permissions.show', compact('item', 'typeDeleted'));
    }

    /**
     * Dashbaord Method to restore all deleted permissions.
     *
     * @param Request $request The request
     *
     * @return Response
     */
    public function restoreAllDeletedPermissions(Request $request)
    {
        $deletedPermissions = $this->restoreAllTheDeletedPermissions();

        if ($deletedPermissions['status'] === 'success') {
            return redirect()->route('laravelroles::roles.index')
                ->with('success', trans_choice('laravelroles::laravelroles.flash-messages.successRestoredAllPermissions', $deletedPermissions['count'], ['count' => $deletedPermissions['count']]));
        }

        return redirect()->route('laravelroles::roles.index')
            ->with('error', trans('laravelroles::laravelroles.flash-messages.errorRestoringAllPermissions'));
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function restorePermission(Request $request, $id)
    {
        $permission = $this->restoreDeletedPermission($id);

        return redirect()->route('laravelroles::roles.index')
            ->with('success', trans('laravelroles::laravelroles.flash-messages.successRestoredPermission', ['permission' => $permission->name]));
    }

    /**
     * Destroy all the specified resource from storage.
     *
     * @param Request $request The request
     *
     * @return Response
     */
    public function destroyAllDeletedPermissions(Request $request)
    {
        $deletedPermissions = $this->destroyAllTheDeletedPermissions();

        if ($deletedPermissions['status'] === 'success') {
            return redirect()->route('laravelroles::roles.index')
                ->with('success', trans_choice('laravelroles::laravelroles.flash-messages.successDestroyedAllPermissions', $deletedPermissions['count'], ['count' => $deletedPermissions['count']]));
        }

        return redirect()->route('laravelroles::roles.index')
            ->with('error', trans('laravelroles::laravelroles.flash-messages.errorDestroyingAllPermissions'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $permission = $this->destroyPermission($id);

        return redirect()->route('laravelroles::roles.index')
            ->with('success', trans('laravelroles::laravelroles.flash-messages.successDestroyedPermission', ['permission' => $permission->name]));
    }
}
