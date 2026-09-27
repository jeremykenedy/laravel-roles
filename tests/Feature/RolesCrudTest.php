<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\LaravelRoles;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;
use jeremykenedy\LaravelRoles\Test\User;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->enableGui();

    $admin = User::factory()->create();
    $admin->attachRole(Role::where('slug', 'admin')->firstOrFail());

    $this->actingAs($admin);
});

it('stores a new role', function (): void {
    $response = $this->post(route('laravelroles::roles.store'), [
        'name'        => 'Editor',
        'slug'        => 'editor',
        'description' => 'Edits things',
        'level'       => 3,
    ]);

    $response->assertRedirect(route('laravelroles::roles.index'));

    $this->assertDatabaseHas('roles', ['slug' => 'editor', 'level' => 3]);
});

it('attaches the selected permissions when storing a role', function (): void {
    $permission = Permission::where('slug', 'view.users')->firstOrFail();

    $this->post(route('laravelroles::roles.store'), [
        'name'        => 'Editor',
        'slug'        => 'editor',
        'level'       => 3,
        'permissions' => [$permission->toJson()],
    ]);

    $role = Role::where('slug', 'editor')->firstOrFail();

    expect($role->permissions()->pluck('permissions.id')->all())->toContain($permission->id);
});

it('rejects a role without a name', function (): void {
    $this->post(route('laravelroles::roles.store'), [
        'slug'  => 'editor',
        'level' => 3,
    ])->assertSessionHasErrors('name');

    $this->assertDatabaseMissing('roles', ['slug' => 'editor']);
});

it('rejects a duplicate role slug', function (): void {
    $this->post(route('laravelroles::roles.store'), [
        'name'  => 'Another Admin',
        'slug'  => 'admin',
        'level' => 3,
    ])->assertSessionHasErrors('slug');
});

it('updates a role', function (): void {
    $role = Role::where('slug', 'user')->firstOrFail();

    $this->patch(route('laravelroles::roles.update', $role->id), [
        'id'    => $role->id,
        'name'  => 'Member',
        'slug'  => 'member',
        'level' => 2,
    ])->assertRedirect(route('laravelroles::roles.index'));

    expect($role->fresh()->name)->toBe('Member')
        ->and($role->fresh()->level)->toBe(2);
});

it('resyncs the selected permissions when updating a role', function (): void {
    $role = Role::where('slug', 'user')->firstOrFail();
    $kept = Permission::where('slug', 'view.users')->firstOrFail();
    $dropped = Permission::where('slug', 'create.users')->firstOrFail();

    $role->syncPermissions([$dropped->id]);

    $this->patch(route('laravelroles::roles.update', $role->id), [
        'id'          => $role->id,
        'name'        => 'Member',
        'slug'        => 'member',
        'level'       => 2,
        'permissions' => [$kept->toJson()],
    ])->assertRedirect(route('laravelroles::roles.index'));

    $ids = $role->fresh()->permissions()->pluck('permissions.id')->all();

    expect($ids)->toContain($kept->id)
        ->and($ids)->not->toContain($dropped->id);
});

it('soft deletes a role', function (): void {
    $role = Role::where('slug', 'user')->firstOrFail();

    $this->delete(route('laravelroles::roles.destroy', $role->id))
        ->assertRedirect(route('laravelroles::roles.index'));

    expect(Role::find($role->id))->toBeNull()
        ->and(Role::onlyTrashed()->find($role->id))->not->toBeNull();
});

it('restores a soft deleted role', function (): void {
    $role = Role::where('slug', 'user')->firstOrFail();
    $role->delete();

    $this->put(route('laravelroles::role-restore', $role->id))
        ->assertRedirect(route('laravelroles::roles.index'));

    expect(Role::find($role->id))->not->toBeNull();
});

it('restores every soft deleted role', function (): void {
    Role::where('slug', 'user')->firstOrFail()->delete();
    Role::where('slug', 'unverified')->firstOrFail()->delete();

    $this->post(route('laravelroles::roles-deleted-restore-all'))
        ->assertRedirect(route('laravelroles::roles.index'));

    expect(Role::onlyTrashed()->count())->toBe(0)
        ->and(Role::count())->toBe(3);
});

it('force deletes a soft deleted role', function (): void {
    $role = Role::where('slug', 'user')->firstOrFail();
    $role->delete();

    $this->delete(route('laravelroles::role-item-destroy', $role->id))
        ->assertRedirect(route('laravelroles::roles.index'));

    expect(Role::withTrashed()->find($role->id))->toBeNull();
});

it('force deletes every soft deleted role', function (): void {
    Role::where('slug', 'user')->firstOrFail()->delete();

    $this->delete(route('laravelroles::destroy-all-deleted-roles'))
        ->assertRedirect(route('laravelroles::roles.index'));

    expect(Role::onlyTrashed()->count())->toBe(0);
});

it('stores a new permission', function (): void {
    $this->post(route('laravelroles::permissions.store'), [
        'name'  => 'Can Archive',
        'slug'  => 'archive.posts',
        'model' => 'Permission',
    ])->assertRedirect(route('laravelroles::roles.index'));

    $this->assertDatabaseHas('permissions', ['slug' => 'archive.posts']);
});

it('rejects a permission without a model', function (): void {
    $this->post(route('laravelroles::permissions.store'), [
        'name' => 'Can Archive',
        'slug' => 'archive.posts',
    ])->assertSessionHasErrors('model');
});

it('updates a permission', function (): void {
    $permission = Permission::where('slug', 'view.users')->firstOrFail();

    $this->patch(route('laravelroles::permissions.update', $permission->id), [
        'id'    => $permission->id,
        'name'  => 'Can Read Users',
        'slug'  => 'read.users',
        'model' => 'Permission',
    ])->assertRedirect(route('laravelroles::roles.index'));

    expect($permission->fresh()->slug)->toBe('read.users');
});

it('soft deletes and restores a permission', function (): void {
    $permission = Permission::where('slug', 'view.users')->firstOrFail();

    $this->delete(route('laravelroles::permissions.destroy', $permission->id));
    expect(Permission::find($permission->id))->toBeNull();

    $this->put(route('laravelroles::permission-restore', $permission->id));
    expect(Permission::find($permission->id))->not->toBeNull();
});

it('force deletes a soft deleted permission', function (): void {
    $permission = Permission::where('slug', 'view.users')->firstOrFail();
    $permission->delete();

    $this->delete(route('laravelroles::permission-item-destroy', $permission->id))
        ->assertRedirect(route('laravelroles::roles.index'));

    expect(Permission::withTrashed()->find($permission->id))->toBeNull();
});

it('slugs a role slug through the configured separator', function (): void {
    $this->post(route('laravelroles::roles.store'), [
        'name'  => 'Content Editor',
        'slug'  => 'Content Editor',
        'level' => 3,
    ]);

    expect(Role::where('name', 'Content Editor')->firstOrFail()->slug)->toBe('content.editor');
});

it('refuses to store a role for a user without the configured role', function (): void {
    $this->actingAs(User::factory()->create())
        ->post(route('laravelroles::roles.store'), [
            'name'  => 'Editor',
            'slug'  => 'editor',
            'level' => 3,
        ])
        ->assertForbidden();

    $this->assertDatabaseMissing('roles', ['slug' => 'editor']);
});

it('refuses to store a permission for a user without the configured role', function (): void {
    $this->actingAs(User::factory()->create())
        ->post(route('laravelroles::permissions.store'), [
            'name'  => 'Can Archive',
            'slug'  => 'archive.posts',
            'model' => 'Permission',
        ])
        ->assertForbidden();
});

it('authorizes by permission when the middleware type is permissions', function (): void {
    config([
        'roles.rolesGuiCreateNewRolesMiddlewareType' => 'permissions',
        'roles.rolesGuiCreateNewRolesMiddleware'     => 'edit.users',
    ]);

    $user = User::factory()->create();
    $user->attachPermission(Permission::where('slug', 'edit.users')->firstOrFail());

    $this->actingAs($user)
        ->post(route('laravelroles::roles.store'), [
            'name'  => 'Editor',
            'slug'  => 'editor',
            'level' => 3,
        ])
        ->assertRedirect(route('laravelroles::roles.index'));
});

it('rolls the new role back when attaching its permissions fails', function (): void {
    config(['roles.models.permission' => 'App\\Models\\ThisPermissionModelIsMissing']);

    try {
        (new LaravelRoles())->storeRoleWithPermissions(
            ['name' => 'Editor', 'slug' => 'editor', 'description' => '', 'level' => 3],
            ['{"id":1}']
        );
    } catch (Throwable $e) {
        // The point of the test is what the database looks like afterwards.
    }

    expect(Role::where('slug', 'editor')->exists())->toBeFalse();
});

it('keeps the deleted roles and reports an error when destroying them fails', function (): void {
    Role::where('slug', 'user')->firstOrFail()->delete();
    Log::spy();

    config(['roles.models.defaultUser' => 'App\\Models\\ThisUserModelIsMissing']);

    $result = (new LaravelRoles())->destroyAllTheDeletedRoles();

    expect($result['status'])->toBe('error')
        ->and($result['count'])->toBe(1)
        ->and(Role::onlyTrashed()->count())->toBe(1);

    Log::shouldHaveReceived('error')->once();
});

it('refuses to create a role when the gate type is not one it understands', function (): void {
    config(['roles.rolesGuiCreateNewRolesMiddlewareType' => 'admins']);

    $this->post(route('laravelroles::roles.store'), [
        'name'  => 'Editor',
        'slug'  => 'editor',
        'level' => 3,
    ])->assertForbidden();

    expect(Role::where('slug', 'editor')->exists())->toBeFalse();
});

it('refuses to create a permission when the gate type is not one it understands', function (): void {
    config(['roles.rolesGuiCreateNewPermissionMiddlewareType' => 'admins']);

    $this->post(route('laravelroles::permissions.store'), [
        'name'  => 'Can Archive',
        'slug'  => 'archive.posts',
        'model' => 'Post',
    ])->assertForbidden();

    expect(Permission::where('slug', 'archive.posts')->exists())->toBeFalse();
});

it('accepts the plural gate type the config comment names', function (string $type): void {
    config([
        'roles.rolesGuiCreateNewRolesMiddlewareType' => $type,
        'roles.rolesGuiCreateNewRolesMiddleware'     => $type === 'roles' ? 'admin' : 'create.users',
    ]);

    $admin = User::factory()->create();
    $admin->attachRole(Role::where('slug', 'admin')->firstOrFail());
    $admin->attachPermission(Permission::where('slug', 'create.users')->firstOrFail());

    $this->actingAs($admin)
        ->post(route('laravelroles::roles.store'), ['name' => 'Editor', 'slug' => 'editor', 'level' => 3])
        ->assertRedirect(route('laravelroles::roles.index'));
})->with(['roles', 'permissions']);

it('refuses a user without the configured role', function (): void {
    $this->actingAs(User::factory()->create())
        ->post(route('laravelroles::roles.store'), ['name' => 'Editor', 'slug' => 'editor', 'level' => 3])
        ->assertForbidden();
});

it('leaves the form open when no gate is configured at all', function (): void {
    config(['roles.rolesGuiCreateNewRolesMiddlewareType' => '']);

    $this->actingAs(User::factory()->create())
        ->post(route('laravelroles::roles.store'), ['name' => 'Editor', 'slug' => 'editor', 'level' => 3])
        ->assertRedirect(route('laravelroles::roles.index'));
});

it('restores every soft deleted permission', function (): void {
    Permission::where('slug', 'view.users')->firstOrFail()->delete();
    Permission::where('slug', 'edit.users')->firstOrFail()->delete();

    $this->post(route('laravelroles::permissions-deleted-restore-all'))
        ->assertRedirect(route('laravelroles::roles.index'));

    expect(Permission::onlyTrashed()->count())->toBe(0)
        ->and(Permission::count())->toBe(4);
});

it('force deletes every soft deleted permission', function (): void {
    $permission = Permission::where('slug', 'view.users')->firstOrFail();
    $role = Role::where('slug', 'admin')->firstOrFail();
    $user = User::factory()->create();

    $user->attachPermission($permission);
    $permission->delete();

    $this->delete(route('laravelroles::destroy-all-deleted-permissions'))
        ->assertRedirect(route('laravelroles::roles.index'));

    expect(Permission::withTrashed()->find($permission->id))->toBeNull()
        ->and($role->fresh()->permissions()->pluck('permissions.id')->all())->not->toContain($permission->id);
});

it('restores a single soft deleted permission', function (): void {
    $permission = Permission::where('slug', 'view.users')->firstOrFail();
    $permission->delete();

    $this->put(route('laravelroles::permission-restore', $permission->id))
        ->assertRedirect(route('laravelroles::roles.index'));

    expect(Permission::find($permission->id))->not->toBeNull();
});

it('shows a soft deleted permission with the users that held it', function (): void {
    $permission = Permission::where('slug', 'view.users')->firstOrFail();
    $user = User::factory()->create();
    $user->attachPermission($permission);
    $permission->delete();

    $this->get(route('laravelroles::permission-show-deleted', $permission->id))
        ->assertOk()
        ->assertSee('View Users');
});

it('reports an error when there are no deleted permissions to destroy', function (): void {
    $result = (new LaravelRoles())->destroyAllTheDeletedPermissions();

    expect($result)->toBe(['status' => 'error', 'count' => 0]);
});

it('reports an error when there are no deleted permissions to restore', function (): void {
    $result = (new LaravelRoles())->restoreAllTheDeletedPermissions();

    expect($result)->toBe(['status' => 'error', 'count' => 0]);
});

it('lists the users that hold a permission through their roles', function (): void {
    $permission = Permission::where('slug', 'view.users')->firstOrFail();
    $admin = User::factory()->create();
    $admin->attachRole(Role::where('slug', 'admin')->firstOrFail());

    $users = (new LaravelRoles())->getAllUsersForPermission($permission);

    expect($users->pluck('id')->all())->toContain($admin->id);
});

it('lists the users that hold a role', function (): void {
    $role = Role::where('slug', 'admin')->firstOrFail();
    $admin = User::factory()->create();
    $admin->attachRole($role);

    $users = (new LaravelRoles())->getRoleUsers($role->id);

    expect(collect($users)->pluck('id')->all())->toContain($admin->id);
});

it('lists the permissions attached to a role', function (): void {
    $role = Role::where('slug', 'admin')->firstOrFail();

    $permissions = (new LaravelRoles())->getRolePermissions($role->id);

    expect(collect($permissions)->count())->toBeGreaterThan(0);
});
