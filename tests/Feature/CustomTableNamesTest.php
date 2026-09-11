<?php

declare(strict_types=1);

use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;
use jeremykenedy\LaravelRoles\Test\User;

uses(RefreshDatabase::class);

/**
 * Rebuild the package schema under the table names currently in config.
 */
function migratePackageTables(): void
{
    foreach (glob(dirname(__DIR__, 2).'/src/Database/Migrations/*.php') as $file) {
        (require $file)->up();
    }
}

function useCustomTableNames(): void
{
    config([
        'roles.rolesTable'           => 'acl_roles',
        'roles.roleUserTable'        => 'acl_role_user',
        'roles.permissionsTable'     => 'acl_permissions',
        'roles.permissionsRoleTable' => 'acl_permission_role',
        'roles.permissionsUserTable' => 'acl_permission_user',
    ]);

    migratePackageTables();
}

it('queries the configured pivot table for user permissions', function (): void {
    useCustomTableNames();

    $sql = User::factory()->create()->userPermissions()->toSql();

    expect($sql)->toContain('acl_permission_user')
        ->and($sql)->toContain('acl_permissions')
        ->and($sql)->not->toContain('"permission_user"');
});

it('queries the configured pivot table for role permissions', function (): void {
    useCustomTableNames();

    $sql = (new Role())->permissions()->toSql();

    expect($sql)->toContain('acl_permission_role')
        ->and($sql)->toContain('acl_permissions');
});

it('queries the configured pivot tables for permission relations', function (): void {
    useCustomTableNames();

    $permission = new Permission();

    expect($permission->roles()->toSql())->toContain('acl_permission_role')
        ->and($permission->users()->toSql())->toContain('acl_permission_user');
});

it('builds the inherited permission query from the configured tables', function (): void {
    useCustomTableNames();

    $sql = User::factory()->create()->rolePermissions()->toSql();

    expect($sql)->toContain('acl_permissions')
        ->and($sql)->toContain('acl_permission_role')
        ->and($sql)->toContain('acl_roles');
});

it('resolves role and permission checks end to end under custom table names', function (): void {
    useCustomTableNames();

    $role = Role::create(['name' => 'Editor', 'slug' => 'editor', 'description' => '', 'level' => 3]);
    $permission = Permission::create([
        'name'        => 'Can Publish',
        'slug'        => 'publish.posts',
        'description' => '',
        'model'       => 'Permission',
    ]);
    $role->attachPermission($permission);

    $user = User::factory()->create();
    $user->attachRole($role);

    expect($user->hasRole('editor'))->toBeTrue()
        ->and($user->hasPermission('publish.posts'))->toBeTrue()
        ->and($user->level())->toBe(3);
});

it('writes role assignments into the configured pivot table', function (): void {
    useCustomTableNames();

    $role = Role::create(['name' => 'Editor', 'slug' => 'editor', 'description' => '', 'level' => 3]);
    $user = User::factory()->create();
    $user->attachRole($role);

    $this->assertDatabaseHas('acl_role_user', [
        'role_id' => $role->id,
        'user_id' => $user->id,
    ]);
});

it('writes direct permission grants into the configured pivot table', function (): void {
    useCustomTableNames();

    $permission = Permission::create([
        'name'        => 'Can Publish',
        'slug'        => 'publish.posts',
        'description' => '',
        'model'       => 'Permission',
    ]);
    $user = User::factory()->create();
    $user->attachPermission($permission);

    $this->assertDatabaseHas('acl_permission_user', [
        'permission_id' => $permission->id,
        'user_id'       => $user->id,
    ]);
});
