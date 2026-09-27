<?php

declare(strict_types=1);

use Illuminate\Support\ServiceProvider;
use jeremykenedy\LaravelRoles\Database\Seeders\DefaultConnectRelationshipsSeeder;
use jeremykenedy\LaravelRoles\Database\Seeders\DefaultPermissionsTableSeeder;
use jeremykenedy\LaravelRoles\Database\Seeders\DefaultRolesTableSeeder;
use jeremykenedy\LaravelRoles\LaravelRoles;
use jeremykenedy\LaravelRoles\RolesFacade;
use jeremykenedy\LaravelRoles\RolesServiceProvider;
use jeremykenedy\LaravelRoles\Support\CssFramework;
use jeremykenedy\LaravelRoles\Test\RefreshDatabase;

uses(RefreshDatabase::class);

it('binds the accessor the shipped facade points at', function (): void {
    expect(app('laravelroles'))->toBeInstanceOf(LaravelRoles::class);
});

it('answers helper calls through the facade', function (): void {
    expect(RolesFacade::getRoles())->toHaveCount(3)
        ->and(RolesFacade::getPermissions())->toHaveCount(4);
});

it('publishes the config, migrations and seeds under the package tag', function (): void {
    $paths = ServiceProvider::pathsToPublish(RolesServiceProvider::class, 'laravelroles');

    $destinations = array_values($paths);

    expect(implode(' ', $destinations))->toContain('config')
        ->and(implode(' ', $destinations))->toContain('migrations')
        ->and(implode(' ', $destinations))->toContain('seeders');
});

it('publishes a view tag for every framework', function (string $framework): void {
    $paths = ServiceProvider::pathsToPublish(RolesServiceProvider::class, 'laravelroles-views-'.$framework);

    expect($paths)->not->toBeEmpty()
        ->and(array_key_first($paths))->toBe(CssFramework::viewPath($framework));
})->with(CssFramework::supported());

it('publishes views to the directory the view finder already checks', function (): void {
    $paths = ServiceProvider::pathsToPublish(RolesServiceProvider::class, 'laravelroles-views');

    expect(array_values($paths)[0])->toEndWith('resources/views/vendor/laravelroles');
});

it('registers package migrations only when the config flag is on', function (): void {
    config(['roles.defaultMigrations.enabled' => false]);
    $migrator = app('migrator');
    $before = $migrator->paths();

    (new RolesServiceProvider(app()))->register();

    expect($migrator->paths())->toEqual($before);

    config(['roles.defaultMigrations.enabled' => true]);
    (new RolesServiceProvider(app()))->register();

    expect($migrator->paths())->toContain(realpath(dirname(__DIR__, 2).'/src/Database/Migrations'));
});

it('does not load gui views while the gui is disabled', function (): void {
    config(['roles.rolesGuiEnabled' => false]);

    (new RolesServiceProvider(app()))->register();

    expect(app('view')->getFinder()->getHints())->not->toHaveKey('laravelroles');
});

it('loads the view set for the resolved framework', function (string $framework): void {
    $this->enableGui($framework);

    $hints = app('view')->getFinder()->getHints()['laravelroles'];

    expect($hints)->toContain(CssFramework::viewPath($framework));
})->with(CssFramework::supported());

it('registers the package seeders with a seed handler when one exists', function (): void {
    $registered = [];

    app()->singleton('seed.handler', function () use (&$registered) {
        return new class($registered) {
            public function __construct(public &$registered)
            {
            }

            public function register($seeder): void
            {
                $this->registered[] = $seeder;
            }
        };
    });

    (new RolesServiceProvider(app()))->register();

    app('seed.handler');

    expect($registered)->toContain(
        DefaultPermissionsTableSeeder::class,
        DefaultRolesTableSeeder::class,
        DefaultConnectRelationshipsSeeder::class,
    );
});

it('boots without a seed handler binding', function (): void {
    $app = app();
    $app->forgetInstance('seed.handler');

    $provider = new RolesServiceProvider($app);

    $provider->register();
    $provider->boot();

    expect(true)->toBeTrue();
});
