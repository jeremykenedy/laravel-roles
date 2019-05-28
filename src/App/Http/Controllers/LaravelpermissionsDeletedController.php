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

        return view('laravelroles::laravelroles.crud.permissions.deleted.index', $data);
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
        $item = $this->getDeletedPermissionAndDetails($id);
        $typeDeleted = 'deleted';

        return view('laravelroles::laravelroles.crud.permissions.show', compact('item', 'typeDeleted'));
    }

    /**
     * Dashbaord Method to restore all deleted permissions.
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Http\Response
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
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
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
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = $this->destroyPermission($id);

        return redirect()->route('laravelroles::roles.index')
                    ->with('success', trans('laravelroles::laravelroles.flash-messages.successDestroyedPermission', ['permission' => $permission->name]));
    }
}
