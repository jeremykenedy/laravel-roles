<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Exceptions;

class PermissionDeniedException extends AccessDeniedException
{
    /**
     * Create a new permission denied exception instance.
     *
     * @param string $permission
     */
    public function __construct($permission)
    {
        parent::__construct(sprintf("You don't have a required ['%s'] permission.", $permission));
    }
}
