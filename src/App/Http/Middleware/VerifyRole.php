<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\App\Exceptions\RoleDeniedException;

class VerifyRole
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request    $request
     * @param int|string $role
     * @return mixed
     *
     * @throws RoleDeniedException
     */
    public function handle($request, Closure $next, ...$role)
    {
        $role = implode(',', $role);
        if ($this->auth->check() && $this->auth->user()->hasRole($role)) {
            return $next($request);
        }

        throw new RoleDeniedException($role);
    }
}
