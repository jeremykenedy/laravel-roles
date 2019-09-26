<?php

namespace jeremykenedy\LaravelRoles;

use Illuminate\Support\ServiceProvider;
use jeremykenedy\LaravelRoles\App\Http\Middleware\VerifyLevel;
use jeremykenedy\LaravelRoles\App\Http\Middleware\VerifyPermission;
use jeremykenedy\LaravelRoles\App\Http\Middleware\VerifyRole;
use jeremykenedy\LaravelRoles\Database\Seeds\DefaultConnectRelationshipsSeeder;
use jeremykenedy\LaravelRoles\Database\Seeds\DefaultPermissionsTableSeeder;
use jeremykenedy\LaravelRoles\Database\Seeds\DefaultRolesTableSeeder;
use jeremykenedy\LaravelRoles\Database\Seeds\DefaultUsersTableSeeder;

class RolesServiceProvider extends ServiceProvider
{
    private $_packageTag = 'laravelroles';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @param \Illuminate\Routing\Router $router The router
     *
     * @return void
     */
    public function boot()
    {
        $this->app['router']->aliasMiddleware('role', VerifyRole::class);
        $this->app['router']->aliasMiddleware('permission', VerifyPermission::class);
        $this->app['router']->aliasMiddleware('level', VerifyLevel::class);
        if (config('roles.rolesGuiEnabled')) {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        }
        $this->loadTranslationsFrom(__DIR__.'/resources/lang/', $this->_packageTag);
        $this->registerBladeExtensions();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/roles.php', 'roles');
        $this->loadMigrations();
        if (config('roles.rolesGuiEnabled')) {
            $this->loadViewsFrom(__DIR__.'/resources/views/', $this->_packageTag);
        }
        $this->publishFiles();
        $this->loadSeedsFrom();
    }

    private function loadMigrations()
    {
        if (config('roles.defaultMigrations.enabled')) {
            $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        }
    }

    /**
     * Loads a seeds.
     *
     * @return void
     */
    private function loadSeedsFrom()
    {
        if (config('roles.defaultSeeds.PermissionsTableSeeder')) {
            $this->app['seed.handler']->register(
                DefaultPermissionsTableSeeder::class
            );
        }

        if (config('roles.defaultSeeds.RolesTableSeeder')) {
            $this->app['seed.handler']->register(
                DefaultRolesTableSeeder::class
            );
        }

        if (config('roles.defaultSeeds.ConnectRelationshipsSeeder')) {
            $this->app['seed.handler']->register(
                DefaultConnectRelationshipsSeeder::class
            );
        }

        if (config('roles.defaultSeeds.UsersTableSeeder')) {
            $this->app['seed.handler']->register(
                DefaultUsersTableSeeder::class
            );
        }
    }

    /**
     * Publish files for package.
     *
     * @return void
     */
    private function publishFiles()
    {
        $publishTag = $this->_packageTag;

        $this->publishes([
            __DIR__.'/config/roles.php' => config_path('roles.php'),
        ], $publishTag.'-config');

        $this->publishes([
            __DIR__.'/Database/Migrations' => database_path('migrations'),
        ], $publishTag.'-migrations');

        $this->publishes([
            __DIR__.'/Database/Seeds/publish' => database_path('seeds'),
        ], $publishTag.'-seeds');

        $this->publishes([
            __DIR__.'/config/roles.php'       => config_path('roles.php'),
            __DIR__.'/Database/Migrations'    => database_path('migrations'),
            __DIR__.'/Database/Seeds/publish' => database_path('seeds'),
        ], $publishTag);
    }

    /**
     * Register Blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->directive('role', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->hasRole({$expression})): ?>";
        });

        $blade->directive('endrole', function () {
            return '<?php endif; ?>';
        });

        $blade->directive('permission', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->hasPermission({$expression})): ?>";
        });

        $blade->directive('endpermission', function () {
            return '<?php endif; ?>';
        });

        $blade->directive('level', function ($expression) {
            $level = trim($expression, '()');

            return "<?php if (Auth::check() && Auth::user()->level() >= {$level}): ?>";
        });

        $blade->directive('endlevel', function () {
            return '<?php endif; ?>';
        });

        $blade->directive('allowed', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->allowed({$expression})): ?>";
        });

        $blade->directive('endallowed', function () {
            return '<?php endif; ?>';
        });
    }
}
