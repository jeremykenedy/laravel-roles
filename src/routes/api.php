<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use jeremykenedy\LaravelRoles\App\Http\Controllers\Api\LaravelRolesApiController;

/*
|--------------------------------------------------------------------------
| Laravel Roles API Routes
|--------------------------------------------------------------------------
|
*/

$middleware = [];

if (config('roles.rolesAPIAuthEnabled')) {
    $middleware[] = 'auth:api';
}

if (config('roles.rolesAPIMiddlewareEnabled')) {
    $middleware[] = config('roles.rolesAPIMiddleware');
}

Route::group([
    'middleware'    => $middleware,
    'as'            => 'laravelroles::',
    'prefix'        => 'api',
], function () {
    Route::apiResource('roles-api', LaravelRolesApiController::class)->only(['index', 'store']);
});
