<?php

namespace jeremykenedy\LaravelRoles\Test;

use Orchestra\Testbench\Factories\UserFactory as TestbenchUserFactory;

class UserFactory extends TestbenchUserFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;
}
