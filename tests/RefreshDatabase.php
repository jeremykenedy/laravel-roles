<?php

namespace jeremykenedy\LaravelRoles\Test;

use Illuminate\Foundation\Testing\RefreshDatabase as TestingRefreshDatabase;
use jeremykenedy\LaravelRoles\Database\Seeders\DefaultConnectRelationshipsSeeder;
use jeremykenedy\LaravelRoles\Database\Seeders\DefaultPermissionsTableSeeder;
use jeremykenedy\LaravelRoles\Database\Seeders\DefaultRolesTableSeeder;
use Illuminate\Database\Seeder;

trait RefreshDatabase
{
    use TestingRefreshDatabase;

    /**
     * Seed the package's default roles and permissions for each test.
     */
    protected bool $seed = true;

    /**
     * Package seeders run, in order, for every seeded test.
     *
     * @var array<int, class-string<Seeder>>
     */
    protected array $packageSeeders = [
        DefaultPermissionsTableSeeder::class,
        DefaultRolesTableSeeder::class,
        DefaultConnectRelationshipsSeeder::class,
    ];

    /**
     * The parameters used when running "migrate:fresh".
     *
     * `--seed` is left off because it resolves Database\Seeders\DatabaseSeeder,
     * which the package test application does not have.
     *
     * @return array<string, mixed>
     */
    protected function migrateFreshUsing()
    {
        return [
            '--drop-views' => $this->shouldDropViews(),
            '--drop-types' => $this->shouldDropTypes(),
        ];
    }

    /**
     * Seed the package's default roles, permissions and their relationships.
     */
    protected function defineDatabaseSeeders(): void
    {
        if (!$this->shouldSeed()) {
            return;
        }

        foreach ($this->packageSeeders as $seeder) {
            $this->seed($seeder);
        }
    }
}
