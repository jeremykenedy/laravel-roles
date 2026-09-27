<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Exceptions;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Thrown by the role, permission and level middleware.
 *
 * It carries a 403 so a denied request is answered as forbidden rather than
 * surfacing as a server error.
 */
class AccessDeniedException extends AccessDeniedHttpException
{
    //
}
