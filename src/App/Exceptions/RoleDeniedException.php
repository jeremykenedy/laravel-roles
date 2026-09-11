<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Exceptions;

class RoleDeniedException extends AccessDeniedException
{
    /**
     * Create a new role denied exception instance.
     *
     * @param string $role
     */
    public function __construct($role)
    {
        parent::__construct(sprintf("You don't have a required ['%s'] role.", $role));
    }
}
