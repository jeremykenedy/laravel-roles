<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\App\Exceptions\LevelDeniedException;

class VerifyLevel
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
     * @param Request $request
     * @param int     $level
     *
     * @throws LevelDeniedException
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $level)
    {
        if ($this->auth->check() && $this->auth->user()->level() >= $level) {
            return $next($request);
        }

        throw new LevelDeniedException($level);
    }
}
