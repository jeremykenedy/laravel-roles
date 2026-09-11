<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\App\Exceptions\PermissionDeniedException;

class VerifyPermission
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
     * @param int|string $permission
     * @return mixed
     *
     * @throws PermissionDeniedException
     */
    public function handle($request, Closure $next, ...$permission)
    {
        $permission = implode(',', $permission);
        if ($this->auth->check() && $this->auth->user()->hasPermission($permission)) {
            return $next($request);
        }

        throw new PermissionDeniedException($permission);
    }
}
