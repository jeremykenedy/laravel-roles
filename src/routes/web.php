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
    Route::resource('permissions', 'LaravelPermissionsController');
});
