<?php

declare(strict_types=1);

use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;
use jeremykenedy\LaravelRoles\Test\User;

uses(RefreshDatabase::class);

function apiAdmin(): User
{
    $admin = User::factory()->create();
    $admin->attachRole(Role::where('slug', 'admin')->firstOrFail());

    return $admin;
}

it('does not register api routes while the api is disabled', function (): void {
    $names = collect(app('router')->getRoutes())->map->getName()->filter();

    expect($names)->not->toContain('laravelroles::roles-api.index');
});

it('registers only the actions the controller implements', function (): void {
    $this->enableApi();

    $names = collect(app('router')->getRoutes())->map->getName()->filter()->all();

    expect($names)->toContain('laravelroles::roles-api.index', 'laravelroles::roles-api.store')
        ->and($names)->not->toContain(
            'laravelroles::roles-api.show',
            'laravelroles::roles-api.update',
            'laravelroles::roles-api.destroy',
        );
});

it('rejects an unauthenticated request', function (): void {
    $this->enableApi();

    $this->getJson('/api/roles-api')->assertUnauthorized();
});

it('returns the roles and permissions payload', function (): void {
    $this->enableApi();

    $this->actingAs(apiAdmin(), 'api')
        ->getJson('/api/roles-api')
        ->assertOk()
        ->assertJsonPath('code', 200)
        ->assertJsonPath('status', 'success')
        ->assertJsonStructure([
            'code',
            'status',
            'message',
            'data' => ['roles', 'permissions', 'users'],
        ]);
});

it('creates a role over the api', function (): void {
    $this->enableApi();

    $this->actingAs(apiAdmin(), 'api')
        ->postJson('/api/roles-api', [
            'name'  => 'Editor',
            'slug'  => 'editor',
            'level' => 3,
        ])
        ->assertCreated()
        ->assertJsonPath('status', 'created')
        ->assertJsonPath('role.slug', 'editor');

    $this->assertDatabaseHas('roles', ['slug' => 'editor']);
});

it('validates a role created over the api', function (): void {
    $this->enableApi();

    $this->actingAs(apiAdmin(), 'api')
        ->postJson('/api/roles-api', ['slug' => 'editor'])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'level']);
});
