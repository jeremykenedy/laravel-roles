<?php

namespace jeremykenedy\LaravelRoles;

use Illuminate\Support\Facades\Facade;

class RolesFacade extends Facade
{
    /**
     * Gets the facade accessor.
     *
     * @return string The facade accessor.
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelroles';
    }
}
