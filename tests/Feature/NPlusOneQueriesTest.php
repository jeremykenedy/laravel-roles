<?php

namespace jeremykenedy\LaravelRoles\Test\Feature;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;
use jeremykenedy\LaravelRoles\Test\TestCase;
use jeremykenedy\LaravelRoles\Test\User;

class NPlusOneQueriesTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected $usersCount = 10;
    protected $rolesCount = 3;
    protected $permissionsCount = 4;

    protected $queries = 0;

    protected function setUp(): void
    {
        parent::setUp();

        $this->assertEquals($this->rolesCount, config('roles.models.role')::count());
        $this->assertEquals($this->permissionsCount, config('roles.models.permission')::count());

        DB::listen(function (QueryExecuted $query) {
            $this->queries++;
        });
    }

    /** @test */
    public function canPreloadRolesOnCollection(): void
    {
        $roleIds = config('roles.models.role')::pluck('id');

        User::factory($this->usersCount)->create()
            ->each(function (User $user) use ($roleIds) {
                $user->roles()->attach($roleIds);
            });
        $this->assertEquals($this->usersCount, User::count());

        $this->queries = 0;

        // without eager load
        $users = User::get();
        $this->assertQueries(1);

        $users->each(function (User $user) {
            $user->getRoles();
        });
        $this->assertQueries($this->usersCount);

        // with eager load
        $users = User::with('roles')->get();
        $this->assertQueries(2);

        $users->each(function (User $user) {
            $user->getRoles();
        });
        $this->assertQueries(0);
    }

    /** @test */
    public function canAttachRoles()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $roleId = config('roles.models.role')::value('id');

        $this->queries = 0;
        $user->attachRole($roleId);
        // getRoles + attach
        $this->assertQueries(2);

        $this->queries = 0;
        $user->detachAllRoles();
        $user->attachRole($roleId);
        // detach + getRoles + attach
        $this->assertQueries(3);
    }

    /** @test */
    public function itCachesRoles()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->queries = 0;
        $user->getRoles();
        $this->assertQueries(1);

        $user->getRoles();
        $this->assertQueries(0);

        $user->roles;
        $this->assertQueries(0);
    }

    /** @test */
    public function itCachesPermissions()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $roleIds = config('roles.models.role')::pluck('id');
        $user->roles()->attach($roleIds);

        $this->queries = 0;
        $user->getPermissions();
        // rolePermissions(+getRoles) + userPermissions
        $this->assertQueries(3);

        $user->getPermissions();
        $this->assertQueries(0);

        $user->permissions;
        $this->assertQueries(0);

        /** @var User $user */
        $user = User::find($user->id);

        $this->queries = 0;
        $user->getRoles();
        $this->assertQueries(1);
        $user->getPermissions();
        // rolePermissions + userPermissions
        $this->assertQueries(2);
    }

    /** @test */
    public function canPreloadPermissionsOnCollection(): void
    {
        $roleIds = config('roles.models.role')::pluck('id');

        User::factory($this->usersCount)->create()
            ->each(function (User $user) use ($roleIds) {
                $user->roles()->attach($roleIds);
            });
        $this->assertEquals($this->usersCount, User::count());

        $this->queries = 0;

        // without eager load
        $users = User::get();
        $this->assertQueries(1);

        $users->each(function (User $user) {
            $user->getPermissions();
        });
        // rolePermissions(+getRoles) + userPermissions
        $this->assertQueries($this->usersCount * 3);

        // with eager load
        // TODO: 'rolePermissions' relation
        $users = User::with('roles', 'userPermissions')->get();
        $this->assertQueries(3);

        $users->each(function (User $user) {
            $user->getPermissions();
        });
        // TODO: optimize via relations: userPermissions and rolePermissions
        $this->assertQueries(20);
        // $this->assertQueries(0);
    }

    protected function assertQueries(int $count): void
    {
        $this->assertEquals($count, $this->queries);
        $this->queries = 0;
    }
}
