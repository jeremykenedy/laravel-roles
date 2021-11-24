<?php

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
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request    $request
     * @param \Closure   $next
     * @param int|string $role
     *
     * @throws RoleDeniedException
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        $role = join(',', $role);
        if ($this->auth->check() && $this->auth->user()->hasRole($role)) {
            return $next($request);
        }

        throw new RoleDeniedException($role);
    }
}
