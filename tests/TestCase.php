<?php

namespace jeremykenedy\LaravelRoles\Test;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Facades\View;
use jeremykenedy\LaravelRoles\RolesFacade;
use jeremykenedy\LaravelRoles\RolesServiceProvider;
use jeremykenedy\LaravelRoles\Support\CssFramework;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Seedster\Handlers\SeedHandler;
use Illuminate\Foundation\Application;

class TestCase extends OrchestraTestCase
{
    /**
     * Config overrides applied to `roles.*` for a test case.
     *
     * @var array<string, mixed>
     */
    protected array $roleConfig = [];

    /**
     * Get package providers.
     *
     * @param Application $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app)
    {
        return [RolesServiceProvider::class];
    }

    /**
     * Get package aliases.
     *
     * @param Application $app
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
     * @param Application $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        $app->singleton('seed.handler', function ($app) {
            return new SeedHandler($app, collect());
        });

        /** @var ConfigRepository $config */
        $config = $app['config'];

        $config->set('roles.defaultMigrations.enabled', true);

        $config->set('view.paths', array_merge(
            [__DIR__.'/Fixtures/views'],
            (array) $config->get('view.paths', [])
        ));

        $config->set('auth.providers.users.model', User::class);
        $config->set('auth.guards.api', ['driver' => 'session', 'provider' => 'users']);
        $config->set('roles.models.defaultUser', User::class);

        foreach ($this->roleConfig as $key => $value) {
            $config->set('roles.'.$key, $value);
        }
    }

    /**
     * Turn the GUI on for a test and point the view namespace at one framework.
     *
     * The provider decides both in register(), which testbench runs before
     * getEnvironmentSetUp(), so the only way to exercise the GUI is to apply
     * the config and register the provider again.
     *
     * @param string $framework
     * @param array<string, mixed> $config
     * @return void
     */
    protected function enableGui($framework = CssFramework::BOOTSTRAP4, array $config = [])
    {
        config([
            'roles.rolesGuiEnabled'           => true,
            'roles.cssFramework'              => $framework,
            'roles.rolesGuiAuthEnabled'       => false,
            'roles.rolesGuiMiddlewareEnabled' => false,
        ]);

        config($config);

        $provider = new RolesServiceProvider($this->app);
        $provider->register();
        $provider->boot();

        View::replaceNamespace('laravelroles', CssFramework::viewPath(CssFramework::resolve()));
    }

    /**
     * Turn the JSON API on for a test.
     *
     * @return void
     */
    protected function enableApi()
    {
        config(['roles.rolesApiEnabled' => true]);

        $provider = new RolesServiceProvider($this->app);
        $provider->register();
        $provider->boot();
    }

    /**
     * Register the migrations the suite runs against.
     *
     * The package migrations are loaded explicitly rather than through
     * roles.defaultMigrations.enabled, because testbench runs
     * getEnvironmentSetUp() after the service provider has registered.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../src/Database/TestMigrations');
        $this->loadMigrationsFrom(__DIR__.'/../src/Database/Migrations');
    }
}
