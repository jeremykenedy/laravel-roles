<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Test\Article;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;
use jeremykenedy\LaravelRoles\Test\User;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->admin = Role::where('slug', 'admin')->firstOrFail();
    $this->user = Role::where('slug', 'user')->firstOrFail();
    $this->unverified = Role::where('slug', 'unverified')->firstOrFail();
});

it('reports no roles for a fresh user', function (): void {
    $user = User::factory()->create();

    expect($user->hasRole('admin'))->toBeFalse()
        ->and($user->getRoles())->toHaveCount(0)
        ->and($user->level())->toBe(0);
});

it('matches a role by slug and by id', function (): void {
    $user = User::factory()->create();
    $user->attachRole($this->user);

    expect($user->hasRole('user'))->toBeTrue()
        ->and($user->hasRole($this->user->id))->toBeTrue()
        ->and($user->hasRole('admin'))->toBeFalse();
});

it('accepts comma and pipe separated role lists', function (): void {
    $user = User::factory()->create();
    $user->attachRole($this->user);

    expect($user->hasRole('admin,user'))->toBeTrue()
        ->and($user->hasRole('admin|user'))->toBeTrue()
        ->and($user->hasRole('admin, user'))->toBeTrue()
        ->and($user->hasRole(['admin', 'user']))->toBeTrue();
});

it('requires every role when all is requested', function (): void {
    $user = User::factory()->create();
    $user->attachRole($this->user);

    expect($user->hasRole('admin,user', true))->toBeFalse();

    $user->attachRole($this->admin);

    expect($user->hasRole('admin,user', true))->toBeTrue();
});

it('reports the highest level of the roles held', function (): void {
    $user = User::factory()->create();
    $user->attachRole($this->unverified);
    expect($user->level())->toBe(0);

    $user->attachRole($this->admin);
    expect($user->level())->toBe(5);
});

it('detaches a single role and all roles', function (): void {
    $user = User::factory()->create();
    $user->attachRole($this->admin);
    $user->attachRole($this->user);
    expect($user->getRoles())->toHaveCount(2);

    $user->detachRole($this->admin);
    expect($user->hasRole('admin'))->toBeFalse()
        ->and($user->hasRole('user'))->toBeTrue();

    $user->detachAllRoles();
    expect($user->getRoles())->toHaveCount(0);
});

it('replaces roles when syncing', function (): void {
    $user = User::factory()->create();
    $user->attachRole($this->admin);

    $user->syncRoles([$this->user->id]);

    expect($user->hasRole('user'))->toBeTrue()
        ->and($user->hasRole('admin'))->toBeFalse();
});

it('does not attach the same role twice', function (): void {
    $user = User::factory()->create();

    $user->attachRole($this->admin);
    $user->attachRole($this->admin);

    expect($user->getRoles())->toHaveCount(1);
});

it('grants the permissions attached to a role', function (): void {
    $user = User::factory()->create();
    $user->attachRole($this->admin);

    expect($user->hasPermission('view.users'))->toBeTrue()
        ->and($user->hasPermission('delete.users'))->toBeTrue()
        ->and($user->getPermissions())->toHaveCount(4);
});

it('grants a permission attached directly to the user', function (): void {
    $user = User::factory()->create();
    $permission = Permission::where('slug', 'edit.users')->firstOrFail();

    expect($user->hasPermission('edit.users'))->toBeFalse();

    $user->attachPermission($permission);

    expect($user->hasPermission('edit.users'))->toBeTrue();
});

it('detaches and syncs user permissions', function (): void {
    $user = User::factory()->create();
    $view = Permission::where('slug', 'view.users')->firstOrFail();
    $edit = Permission::where('slug', 'edit.users')->firstOrFail();

    $user->attachPermission($view);
    expect($user->hasPermission('view.users'))->toBeTrue();

    $user->syncPermissions([$edit->id]);
    expect($user->fresh()->hasPermission('edit.users'))->toBeTrue();

    $user->detachAllPermissions();
    expect($user->fresh()->getPermissions())->toHaveCount(0);
});

it('sees a permission attached after the relation was eager loaded', function (): void {
    $user = User::with('userPermissions')->findOrFail(User::factory()->create()->id);

    $user->attachPermission(Permission::where('slug', 'edit.users')->firstOrFail());

    expect($user->hasPermission('edit.users'))->toBeTrue();
});

it('stops seeing a permission detached after the relation was eager loaded', function (): void {
    $user = User::factory()->create();
    $user->attachPermission(Permission::where('slug', 'edit.users')->firstOrFail());

    $user = User::with('userPermissions')->findOrFail($user->id);
    expect($user->hasPermission('edit.users'))->toBeTrue();

    $user->detachPermission(Permission::where('slug', 'edit.users')->firstOrFail());

    expect($user->hasPermission('edit.users'))->toBeFalse();
});

it('requires every permission when all is requested', function (): void {
    $user = User::factory()->create();
    $user->attachPermission(Permission::where('slug', 'view.users')->firstOrFail());

    expect($user->hasPermission('view.users,delete.users', true))->toBeFalse()
        ->and($user->hasPermission('view.users,delete.users'))->toBeTrue();
});

it('inherits permissions from lower level roles when inheritance is on', function (): void {
    config(['roles.inheritance' => true]);

    $lower = Role::create(['name' => 'Lower', 'slug' => 'lower', 'description' => '', 'level' => 1]);
    $lower->attachPermission(Permission::where('slug', 'view.users')->firstOrFail());

    $higher = Role::create(['name' => 'Higher', 'slug' => 'higher', 'description' => '', 'level' => 9]);

    $user = User::factory()->create();
    $user->attachRole($higher);

    expect($user->hasPermission('view.users'))->toBeTrue();
});

it('does not inherit lower level permissions when inheritance is off', function (): void {
    config(['roles.inheritance' => false]);

    $lower = Role::create(['name' => 'Lower', 'slug' => 'lower', 'description' => '', 'level' => 1]);
    $lower->attachPermission(Permission::where('slug', 'view.users')->firstOrFail());

    $higher = Role::create(['name' => 'Higher', 'slug' => 'higher', 'description' => '', 'level' => 9]);

    $user = User::factory()->create();
    $user->attachRole($higher);

    expect($user->hasPermission('view.users'))->toBeFalse();
});

it('ignores permissions that belong to a soft deleted role', function (): void {
    $role = Role::create(['name' => 'Temp', 'slug' => 'temp', 'description' => '', 'level' => 2]);
    $role->attachPermission(Permission::where('slug', 'view.users')->firstOrFail());

    $user = User::factory()->create();
    $user->attachRole($role);
    expect($user->hasPermission('view.users'))->toBeTrue();

    $role->delete();

    expect(User::find($user->id)->hasPermission('view.users'))->toBeFalse();
});

it('returns the pretend answer when pretending is enabled', function (): void {
    config([
        'roles.pretend.enabled' => true,
        'roles.pretend.options' => ['hasRole' => true, 'hasPermission' => false, 'allowed' => true],
    ]);

    $user = User::factory()->create();

    expect($user->hasRole('nope'))->toBeTrue()
        ->and($user->hasPermission('view.users'))->toBeFalse();
});

it('resolves is and can magic methods against roles and permissions', function (): void {
    $user = User::factory()->create();
    $user->attachRole($this->admin);

    expect($user->isAdmin())->toBeTrue()
        ->and($user->isUser())->toBeFalse()
        ->and($user->canViewUsers())->toBeTrue();
});

it('throws for an unknown magic method', function (): void {
    $user = User::factory()->create();

    $user->definitelyNotAMethod();
})->throws(BadMethodCallException::class);

describe('allowed()', function () {
    beforeEach(function (): void {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    });

    it('allows the owner regardless of permissions', function (): void {
        $user = User::factory()->create();
        $article = Article::create(['user_id' => $user->id]);

        expect($user->allowed('edit.users', $article))->toBeTrue();
    });

    it('denies a non owner without a matching permission', function (): void {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $article = Article::create(['user_id' => $owner->id]);

        expect($other->allowed('edit.users', $article))->toBeFalse();
    });

    it('allows a non owner holding a permission scoped to the model', function (): void {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $article = Article::create(['user_id' => $owner->id]);

        $permission = Permission::create([
            'name'        => 'Can Edit Articles',
            'slug'        => 'edit.articles',
            'description' => '',
            'model'       => Article::class,
        ]);
        $other->attachPermission($permission);

        expect($other->allowed('edit.articles', $article))->toBeTrue();
    });

    it('ignores ownership when the owner flag is false', function (): void {
        $user = User::factory()->create();
        $article = Article::create(['user_id' => $user->id]);

        expect($user->allowed('edit.users', $article, false))->toBeFalse();
    });
});
