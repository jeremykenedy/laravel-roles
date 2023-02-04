<?php

namespace jeremykenedy\LaravelRoles\Test;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase as TestingRefreshDatabase;

trait RefreshDatabase
{
    use TestingRefreshDatabase;

    protected $seeder = [
        \jeremykenedy\LaravelRoles\Database\Seeders\DefaultPermissionsTableSeeder::class,
        \jeremykenedy\LaravelRoles\Database\Seeders\DefaultRolesTableSeeder::class,
        \jeremykenedy\LaravelRoles\Database\Seeders\DefaultConnectRelationshipsSeeder::class,
    ];

    /**
     * Refresh the in-memory database.
     *
     * @return void
     */
    protected function refreshInMemoryDatabase()
    {
        $this->artisan('migrate', $this->migrateUsing());

        if ($this->shouldSeed()) {
            $options = ['--force' => true];

            if ($seeders = $this->seeder()) {
                if (is_array($seeders)) {
                    foreach ($seeders as $seeder) {
                        $options['--class'] = $seeder;
                        $this->artisan('db:seed', $options);
                    }
                } else {
                    $options['--class'] = $seeders;
                    $this->artisan('db:seed', $options);
                }
            } else {
                $this->artisan('db:seed', $options);
            }
        }

        $this->app[Kernel::class]->setArtisan(null);
    }

    /**
     * The parameters that should be used when running "migrate".
     *
     * @return array
     */
    protected function migrateUsing()
    {
        return [
            /**
             * Non standard path.
             *
             * $this->laravel->databasePath().DIRECTORY_SEPARATOR.'migrations'
             * with `vendor/orchestra/testbench-core/laravel` as basePath
             *
             * @see \Illuminate\Database\Console\Migrations\BaseCommand
             */
            '--path'     => realpath(__DIR__.'/../src/Database/Migrations'),
            '--realpath' => true,
        ];
    }
}
