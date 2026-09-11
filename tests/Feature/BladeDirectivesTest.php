<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;
use jeremykenedy\LaravelRoles\Test\User;

uses(RefreshDatabase::class);

it('registers every package directive', function (string $directive): void {
    expect(Blade::getCustomDirectives())->toHaveKey($directive);
})->with(['role', 'endrole', 'permission', 'endpermission', 'level', 'endlevel', 'allowed', 'endallowed']);

it('shows role content to a user holding the role', function (): void {
    $user = User::factory()->create();
    $user->attachRole(Role::where('slug', 'admin')->firstOrFail());
    $this->actingAs($user);

    $rendered = Blade::render("@role('admin')\nyes\n@endrole");

    expect(trim($rendered))->toBe('yes');
});

it('hides role content from a user without the role', function (): void {
    $this->actingAs(User::factory()->create());

    expect(trim(Blade::render("@role('admin')\nyes\n@endrole")))->toBe('');
});

it('hides role content from a guest', function (): void {
    expect(trim(Blade::render("@role('admin')\nyes\n@endrole")))->toBe('');
});

it('shows permission content to a user holding the permission', function (): void {
    $user = User::factory()->create();
    $user->attachRole(Role::where('slug', 'admin')->firstOrFail());
    $this->actingAs($user);

    expect(trim(Blade::render("@permission('view.users')\nyes\n@endpermission")))->toBe('yes');
});

it('hides permission content from a user without the permission', function (): void {
    $this->actingAs(User::factory()->create());

    expect(trim(Blade::render("@permission('view.users')\nyes\n@endpermission")))->toBe('');
});

it('shows level content at or above the level', function (): void {
    $user = User::factory()->create();
    $user->attachRole(Role::where('slug', 'admin')->firstOrFail());
    $this->actingAs($user);

    expect(trim(Blade::render("@level(5)\nyes\n@endlevel")))->toBe('yes');
});

it('hides level content below the level', function (): void {
    $user = User::factory()->create();
    $user->attachRole(Role::where('slug', 'user')->firstOrFail());
    $this->actingAs($user);

    expect(trim(Blade::render("@level(5)\nyes\n@endlevel")))->toBe('');
});
