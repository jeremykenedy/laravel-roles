<?php

/*
|--------------------------------------------------------------------------
| Laravel Roles Web Routes
|--------------------------------------------------------------------------
|
*/
Route::group([
    'middleware'    => ['web'],
    'as'            => 'laravelroles::',
    'namespace'     => 'jeremykenedy\LaravelRoles\App\Http\Controllers',
], function () {
    Route::resource('roles', 'LaravelRolesController');
    Route::get('roles-deleted', 'LaravelRolesDeletedController@index')->name('roles-deleted');
    Route::get('role-deleted/{id}', 'LaravelRolesDeletedController@show')->name('role-show-deleted');
    Route::put('role-restore/{id}', 'LaravelRolesDeletedController@restoreRole')->name('role-restore');
    Route::post('roles-deleted-restore-all', 'LaravelRolesDeletedController@restoreAllDeletedRoles')->name('roles-deleted-restore-all');
    Route::delete('roles-deleted-destroy-all', 'LaravelRolesDeletedController@destroyAllDeletedRoles')->name('destroy-all-deleted-roles');
    Route::delete('role-destroy/{id}', 'LaravelRolesDeletedController@destroy')->name('role-item-destroy');

    Route::resource('permissions', 'LaravelPermissionsController');
});
