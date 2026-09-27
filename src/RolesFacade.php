<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles;

use Illuminate\Support\Facades\Facade;

/**
 * @see LaravelRoles
 */
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
