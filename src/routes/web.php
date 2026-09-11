<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use jeremykenedy\LaravelRoles\App\Http\Controllers\LaravelPermissionsController;
use jeremykenedy\LaravelRoles\App\Http\Controllers\LaravelpermissionsDeletedController;
use jeremykenedy\LaravelRoles\App\Http\Controllers\LaravelRolesController;
use jeremykenedy\LaravelRoles\App\Http\Controllers\LaravelRolesDeletedController;

/*
|--------------------------------------------------------------------------
| Laravel Roles And Permissions Web Routes
|--------------------------------------------------------------------------
|
*/
Route::group([
    'middleware'    => ['web'],
    'as'            => 'laravelroles::',
    'prefix'        => config('roles.GUIRoutesPrefix'),
], function () {
    // Dashboards and CRUD Routes
    Route::resource('roles', LaravelRolesController::class);
    Route::resource('permissions', LaravelPermissionsController::class);

    // Deleted Roles Dashboard and CRUD Routes
    Route::get('roles-deleted', [LaravelRolesDeletedController::class, 'index'])->name('roles-deleted');
    Route::get('role-deleted/{id}', [LaravelRolesDeletedController::class, 'show'])->name('role-show-deleted');
    Route::put('role-restore/{id}', [LaravelRolesDeletedController::class, 'restoreRole'])->name('role-restore');
    Route::post('roles-deleted-restore-all', [LaravelRolesDeletedController::class, 'restoreAllDeletedRoles'])->name('roles-deleted-restore-all');
    Route::delete('roles-deleted-destroy-all', [LaravelRolesDeletedController::class, 'destroyAllDeletedRoles'])->name('destroy-all-deleted-roles');
    Route::delete('role-destroy/{id}', [LaravelRolesDeletedController::class, 'destroy'])->name('role-item-destroy');

    // Deleted Permissions Dashboard and CRUD Routes
    Route::get('permissions-deleted', [LaravelpermissionsDeletedController::class, 'index'])->name('permissions-deleted');
    Route::get('permission-deleted/{id}', [LaravelpermissionsDeletedController::class, 'show'])->name('permission-show-deleted');
    Route::put('permission-restore/{id}', [LaravelpermissionsDeletedController::class, 'restorePermission'])->name('permission-restore');
    Route::post('permissions-deleted-restore-all', [LaravelpermissionsDeletedController::class, 'restoreAllDeletedPermissions'])->name('permissions-deleted-restore-all');
    Route::delete('permissions-deleted-destroy-all', [LaravelpermissionsDeletedController::class, 'destroyAllDeletedPermissions'])->name('destroy-all-deleted-permissions');
    Route::delete('permission-destroy/{id}', [LaravelpermissionsDeletedController::class, 'destroy'])->name('permission-item-destroy');
});
