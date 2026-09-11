<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

/**
 * Extends Illuminate's controller, not the application's. Since Laravel 11 the
 * application base controller has no middleware() method, which RolesUsageAuthTrait
 * needs.
 */
abstract class Controller extends BaseController
{
}
