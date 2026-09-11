<?php

declare(strict_types=1);

use jeremykenedy\LaravelRoles\Test\Concerns\CountsQueries;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;
use jeremykenedy\LaravelRoles\Test\User;

uses(RefreshDatabase::class, CountsQueries::class);

const USERS_COUNT = 10;

beforeEach(function (): void {
    expect(config('roles.models.role')::count())->toBe(3);
    expect(config('roles.models.permission')::count())->toBe(4);

    $this->countQueries();
});

it('can preload roles on a collection', function (): void {
    $roleIds = config('roles.models.role')::pluck('id');

    User::factory(USERS_COUNT)->create()
        ->each(fn (User $user) => $user->roles()->attach($roleIds));

    expect(User::count())->toBe(USERS_COUNT);

    $this->resetQueryCount();

    // Without eager loading, every user resolves its own roles relation.
    $users = User::get();
    $this->assertQueries(1);

    $users->each(fn (User $user) => $user->getRoles());
    $this->assertQueries(USERS_COUNT);

    // With eager loading, the roles come back in a single extra query.
    $users = User::with('roles')->get();
    $this->assertQueries(2);

    $users->each(fn (User $user) => $user->getRoles());
    $this->assertQueries(0);
});

it('attaches roles without redundant queries', function (): void {
    $user = User::factory()->create();
    $roleId = config('roles.models.role')::value('id');

    $this->resetQueryCount();

    // getRoles + attach
    $user->attachRole($roleId);
    $this->assertQueries(2);

    // detach + getRoles + attach
    $user->detachAllRoles();
    $user->attachRole($roleId);
    $this->assertQueries(3);
});

it('caches roles on the model instance', function (): void {
    $user = User::factory()->create();

    $this->resetQueryCount();

    $user->getRoles();
    $this->assertQueries(1);

    $user->getRoles();
    $this->assertQueries(0);

    $user->roles;
    $this->assertQueries(0);
});

it('caches permissions on the model instance', function (): void {
    $user = User::factory()->create();
    $user->roles()->attach(config('roles.models.role')::pluck('id'));

    $this->resetQueryCount();

    // rolePermissions (which loads roles) + userPermissions
    $user->getPermissions();
    $this->assertQueries(3);

    $user->getPermissions();
    $this->assertQueries(0);

    $user->permissions;
    $this->assertQueries(0);

    $user = User::find($user->id);

    $this->resetQueryCount();

    $user->getRoles();
    $this->assertQueries(1);

    // rolePermissions + userPermissions
    $user->getPermissions();
    $this->assertQueries(2);
});

it('can preload permissions on a collection', function (): void {
    $roleIds = config('roles.models.role')::pluck('id');

    User::factory(USERS_COUNT)->create()
        ->each(fn (User $user) => $user->roles()->attach($roleIds));

    expect(User::count())->toBe(USERS_COUNT);

    $this->resetQueryCount();

    $users = User::get();
    $this->assertQueries(1);

    // rolePermissions (which loads roles) + userPermissions, per user
    $users->each(fn (User $user) => $user->getPermissions());
    $this->assertQueries(USERS_COUNT * 3);

    $users = User::with('roles', 'userPermissions')->get();
    $this->assertQueries(3);

    // Eager loading roles and userPermissions removes two of the three
    // queries per user; rolePermissions is still resolved per model.
    $users->each(fn (User $user) => $user->getPermissions());
    $this->assertQueries(USERS_COUNT * 2);
});
