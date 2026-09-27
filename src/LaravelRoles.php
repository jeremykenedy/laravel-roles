<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles;

use jeremykenedy\LaravelRoles\Traits\RolesAndPermissionsHelpersTrait;

/**
 * Resolved behind the `laravelroles` container binding used by RolesFacade.
 */
class LaravelRoles
{
    use RolesAndPermissionsHelpersTrait;
}
