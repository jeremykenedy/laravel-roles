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

Route::group([
    'middleware'    => ['auth:api'],
    'as'            => 'laravelroles::',
    'prefix'        => 'api',
], function () {
    Route::apiResource('roles-api', LaravelRolesApiController::class)->only(['index', 'store']);
});
