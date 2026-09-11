<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use jeremykenedy\LaravelRoles\App\Exceptions\LevelDeniedException;
use jeremykenedy\LaravelRoles\App\Exceptions\PermissionDeniedException;
use jeremykenedy\LaravelRoles\App\Exceptions\RoleDeniedException;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;
use jeremykenedy\LaravelRoles\Test\User;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    Route::middleware(['role:admin'])->get('/needs-role', fn () => 'ok');
    Route::middleware(['permission:edit.users'])->get('/needs-permission', fn () => 'ok');
    Route::middleware(['level:5'])->get('/needs-level', fn () => 'ok');

    $this->withoutExceptionHandling();
});

it('registers the role, permission and level middleware aliases', function (): void {
    $aliases = app('router')->getMiddleware();

    expect($aliases)->toHaveKeys(['role', 'permission', 'level']);
});

it('lets a user with the role through', function (): void {
    $user = User::factory()->create();
    $user->attachRole(Role::where('slug', 'admin')->firstOrFail());

    $this->actingAs($user)->get('/needs-role')->assertOk();
});

it('blocks a user without the role', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/needs-role');
})->throws(RoleDeniedException::class);

it('blocks a guest from a role protected route', function (): void {
    $this->get('/needs-role');
})->throws(RoleDeniedException::class);

it('lets a user with the permission through', function (): void {
    $user = User::factory()->create();
    $user->attachRole(Role::where('slug', 'admin')->firstOrFail());

    $this->actingAs($user)->get('/needs-permission')->assertOk();
});

it('blocks a user without the permission', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/needs-permission');
})->throws(PermissionDeniedException::class);

it('lets a user at or above the level through', function (): void {
    $user = User::factory()->create();
    $user->attachRole(Role::where('slug', 'admin')->firstOrFail());

    $this->actingAs($user)->get('/needs-level')->assertOk();
});

it('blocks a user below the level', function (): void {
    $user = User::factory()->create();
    $user->attachRole(Role::where('slug', 'user')->firstOrFail());

    $this->actingAs($user)->get('/needs-level');
})->throws(LevelDeniedException::class);

it('names the denied role in the exception message', function (): void {
    $exception = new RoleDeniedException('admin');

    expect($exception->getMessage())->toBe("You don't have a required ['admin'] role.");
});

it('names the denied permission in the exception message', function (): void {
    $exception = new PermissionDeniedException('edit.users');

    expect($exception->getMessage())->toBe("You don't have a required ['edit.users'] permission.");
});

it('names the denied level in the exception message', function (): void {
    $exception = new LevelDeniedException('5');

    expect($exception->getMessage())->toBe("You don't have a required [5] level.");
});
