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
        $deletedRoleItems = $this->getDeletedRoles()->get();
        $data = [
            'deletedRoleItems' => $deletedRoleItems,
        ];

        return view('laravelroles::laravelroles.crud.roles.deleted.index', $data);
    }

    /**
     * Dashbaord Method to restore all deleted roles
     *
     * @param \Illuminate\Http\Request  $request  The request
     *
     * @return \Illuminate\Http\Response
     */
    public function restoreAllDeletedRoles(Request $request)
    {
        $deletedRoles = $this->restoreAllTheDeletedRoles();

        if ($deletedRoles['status'] === 'success') {
            return redirect()->route('laravelroles::roles.index')
                        ->with('success', trans_choice('laravelroles::laravelroles.flash-messages.successRestoredAllRoles', $deletedRoles['count'], ['count' => $deletedRoles['count']]));
        }

        return redirect()->route('laravelroles::roles.index')
                    ->with('error', trans('laravelroles::laravelroles.flash-messages.errorRestoringAllRoles'));
    }

    /**
     * Destroy all the specified resource from storage.
     *
     * @param \Illuminate\Http\Request  $request  The request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyAllDeletedRoles(Request $request)
    {
        $deletedRoles = $this->destroyAllTheDeletedRoles();

        if ($deletedRoles['status'] === 'success') {
            return redirect()->route('laravelroles::roles.index')
                        ->with('success', trans_choice('laravelroles::laravelroles.flash-messages.successDestroyedAllRoles', $deletedRoles['count'], ['count' => $deletedRoles['count']]));
        }

        return redirect()->route('laravelroles::roles.index')
                    ->with('error', trans('laravelroles::laravelroles.flash-messages.errorDestroyingAllRoles'));
    }

}
