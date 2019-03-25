<?php

namespace jeremykenedy\LaravelRoles\Test;

use jeremykenedy\LaravelRoles\RolesServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return jeremykenedy\LaravelRoles\RolesServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [RolesServiceProvider::class];
    }

    /**
     * Load package alias.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'laravelroles',
        ];
    }
}
