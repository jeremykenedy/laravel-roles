<?php

declare(strict_types=1);

use jeremykenedy\LaravelRoles\Database\Seeders\DefaultPermissionsTableSeeder;
use jeremykenedy\LaravelRoles\Database\Seeders\DefaultRolesTableSeeder;
use jeremykenedy\LaravelRoles\Database\Seeders\DefaultUsersTableSeeder;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;

uses(RefreshDatabase::class);

it('seeds the three default roles with their levels', function (): void {
    expect(Role::pluck('level', 'slug')->all())->toEqual([
        'admin'      => 5,
        'user'       => 1,
        'unverified' => 0,
    ]);
});

it('seeds the four default permissions', function (): void {
    expect(Permission::pluck('slug')->sort()->values()->all())->toEqual([
        'create.users',
        'delete.users',
        'edit.users',
        'view.users',
    ]);
});

it('attaches every permission to the admin role', function (): void {
    $admin = Role::where('slug', 'admin')->firstOrFail();

    expect($admin->permissions()->count())->toBe(4);
});

it('leaves the non admin roles without permissions', function (): void {
    expect(Role::where('slug', 'user')->firstOrFail()->permissions()->count())->toBe(0)
        ->and(Role::where('slug', 'unverified')->firstOrFail()->permissions()->count())->toBe(0);
});

it('does not duplicate rows when a seeder runs twice', function (): void {
    $this->seed(DefaultRolesTableSeeder::class);
    $this->seed(DefaultPermissionsTableSeeder::class);

    expect(Role::count())->toBe(3)
        ->and(Permission::count())->toBe(4);
});

it('seeds the default users with their roles and permissions', function (): void {
    $userModel = config('roles.models.defaultUser');

    expect($userModel::where('email', 'admin@admin.com')->exists())->toBeFalse();

    $this->seed(DefaultUsersTableSeeder::class);

    $admin = $userModel::where('email', 'admin@admin.com')->firstOrFail();
    $user = $userModel::where('email', 'user@user.com')->firstOrFail();

    expect($admin->hasRole('admin'))->toBeTrue()
        ->and($admin->getPermissions())->toHaveCount(Permission::count())
        ->and($user->hasRole('user'))->toBeTrue();
});

it('leaves the default users alone when they already exist', function (): void {
    $userModel = config('roles.models.defaultUser');

    $this->seed(DefaultUsersTableSeeder::class);
    $this->seed(DefaultUsersTableSeeder::class);

    expect($userModel::where('email', 'admin@admin.com')->count())->toBe(1)
        ->and($userModel::where('email', 'user@user.com')->count())->toBe(1);
});
