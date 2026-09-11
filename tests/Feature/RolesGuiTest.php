<?php

declare(strict_types=1);

use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Support\CssFramework;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;
use jeremykenedy\LaravelRoles\Test\User;

uses(RefreshDatabase::class);

dataset('frameworks', CssFramework::supported());

it('does not register gui routes while the gui is disabled', function (): void {
    $names = collect(app('router')->getRoutes())->map->getName()->filter();

    expect($names)->not->toContain('laravelroles::roles.index');
});

it('registers the documented gui route names once enabled', function (): void {
    $this->enableGui();

    $names = collect(app('router')->getRoutes())->map->getName()->filter()->all();

    expect($names)->toContain(
        'laravelroles::roles.index',
        'laravelroles::roles.create',
        'laravelroles::roles.store',
        'laravelroles::roles.show',
        'laravelroles::roles.edit',
        'laravelroles::roles.update',
        'laravelroles::roles.destroy',
        'laravelroles::permissions.index',
        'laravelroles::roles-deleted',
        'laravelroles::role-show-deleted',
        'laravelroles::role-restore',
        'laravelroles::roles-deleted-restore-all',
        'laravelroles::destroy-all-deleted-roles',
        'laravelroles::role-item-destroy',
        'laravelroles::permissions-deleted',
        'laravelroles::permission-show-deleted',
        'laravelroles::permission-restore',
        'laravelroles::permissions-deleted-restore-all',
        'laravelroles::destroy-all-deleted-permissions',
        'laravelroles::permission-item-destroy',
    );
});

it('renders the dashboard', function (string $framework): void {
    $this->enableGui($framework);

    $user = User::factory()->create();
    $user->attachRole(Role::where('slug', 'admin')->firstOrFail());

    $this->actingAs($user)
        ->get(route('laravelroles::roles.index'))
        ->assertOk()
        ->assertSee('Admin')
        ->assertSee('Can View Users');
})->with('frameworks');

it('renders the create role form', function (string $framework): void {
    $this->enableGui($framework);

    $this->actingAs(User::factory()->create())
        ->get(route('laravelroles::roles.create'))
        ->assertOk()
        ->assertSee('name="name"', false)
        ->assertSee('name="slug"', false)
        ->assertSee('name="level"', false)
        ->assertSee('name="permissions[]"', false);
})->with('frameworks');

it('renders the edit role form with the current values', function (string $framework): void {
    $this->enableGui($framework);

    $role = Role::where('slug', 'admin')->firstOrFail();

    $this->actingAs(User::factory()->create())
        ->get(route('laravelroles::roles.edit', $role->id))
        ->assertOk()
        ->assertSee('value="Admin"', false);
})->with('frameworks');

it('renders a role detail page', function (string $framework): void {
    $this->enableGui($framework);

    $role = Role::where('slug', 'admin')->firstOrFail();

    $this->actingAs(User::factory()->create())
        ->get(route('laravelroles::roles.show', $role->id))
        ->assertOk()
        ->assertSee('Admin');
})->with('frameworks');

it('renders the create permission form', function (string $framework): void {
    $this->enableGui($framework);

    $this->actingAs(User::factory()->create())
        ->get(route('laravelroles::permissions.create'))
        ->assertOk()
        ->assertSee('name="model"', false);
})->with('frameworks');

it('renders a permission detail page', function (string $framework): void {
    $this->enableGui($framework);

    $permission = Permission::where('slug', 'view.users')->firstOrFail();

    $this->actingAs(User::factory()->create())
        ->get(route('laravelroles::permissions.show', $permission->id))
        ->assertOk()
        ->assertSee('Can View Users');
})->with('frameworks');

it('renders the deleted roles dashboard', function (string $framework): void {
    $this->enableGui($framework);

    Role::where('slug', 'user')->firstOrFail()->delete();

    $this->actingAs(User::factory()->create())
        ->get(route('laravelroles::roles-deleted'))
        ->assertOk()
        ->assertSee('User');
})->with('frameworks');

it('renders the deleted permissions dashboard', function (string $framework): void {
    $this->enableGui($framework);

    Permission::where('slug', 'view.users')->firstOrFail()->delete();

    $this->actingAs(User::factory()->create())
        ->get(route('laravelroles::permissions-deleted'))
        ->assertOk()
        ->assertSee('Can View Users');
})->with('frameworks');

it('renders a deleted role detail page', function (string $framework): void {
    $this->enableGui($framework);

    $role = Role::where('slug', 'user')->firstOrFail();
    $role->delete();

    $this->actingAs(User::factory()->create())
        ->get(route('laravelroles::role-show-deleted', $role->id))
        ->assertOk()
        ->assertSee('User');
})->with('frameworks');

it('renders markup for the selected framework only', function (): void {
    $this->enableGui(CssFramework::TAILWIND);

    $html = $this->actingAs(User::factory()->create())
        ->get(route('laravelroles::roles.index'))
        ->assertOk()
        ->getContent();

    expect($html)->toContain('dark:')
        ->and($html)->not->toContain('card-header')
        ->and($html)->not->toContain('data-toggle="collapse"');
});

it('renders bootstrap 5 attributes when bootstrap5 is selected', function (): void {
    $this->enableGui(CssFramework::BOOTSTRAP5);

    $html = $this->actingAs(User::factory()->create())
        ->get(route('laravelroles::roles.index'))
        ->assertOk()
        ->getContent();

    expect($html)->toContain('data-bs-toggle')
        ->and($html)->not->toContain('data-toggle="collapse"')
        ->and($html)->not->toContain('dark:');
});
