<?php

declare(strict_types=1);

use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;
use jeremykenedy\LaravelRoles\Database\Seeders\DefaultPermissionsTableSeeder;
use jeremykenedy\LaravelRoles\Database\Seeders\DefaultRolesTableSeeder;

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
