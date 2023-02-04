<?php

namespace jeremykenedy\LaravelRoles\Test;

use jeremykenedy\LaravelRoles\RolesFacade;
use jeremykenedy\LaravelRoles\RolesServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Seedster\Handlers\SeedHandler;

class TestCase extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app)
    {
        return [RolesServiceProvider::class];
    }

    /**
     * Get package aliases.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array<string, class-string>
     */
    protected function getPackageAliases($app)
    {
        return [
            'laravelroles' => RolesFacade::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        $app->singleton('seed.handler', function ($app) {
            return new SeedHandler($app, collect());
        });

        include_once __DIR__.'/../src/Database/TestMigrations/create_users_table.php';

        (new \jeremykenedy\LaravelRoles\Database\TestMigrations\CreateUsersTable())->up();
    }
}
