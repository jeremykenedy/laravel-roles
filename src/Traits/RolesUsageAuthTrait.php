<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\Traits;

trait RolesUsageAuthTrait
{
    /**
     * Whether the GUI is behind Laravel's built in `auth` middleware.
     *
     * @var bool
     */
    private $_rolesGuiAuthEnabled;

    /**
     * Whether the GUI is behind the package's roles/permissions middleware.
     *
     * @var bool
     */
    private $_rolesGuiMiddlewareEnabled;

    /**
     * The roles/permissions middleware applied when enabled.
     *
     * @var string
     */
    private $_rolesGuiMiddleware;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_rolesGuiAuthEnabled = config('roles.rolesGuiAuthEnabled');
        $this->_rolesGuiMiddlewareEnabled = config('roles.rolesGuiMiddlewareEnabled');
        $this->_rolesGuiMiddleware = config('roles.rolesGuiMiddleware');

        if (!method_exists($this, 'middleware')) {
            return;
        }

        if ($this->_rolesGuiAuthEnabled) {
            $this->middleware('auth');
        }

        if ($this->_rolesGuiMiddlewareEnabled) {
            $this->middleware($this->_rolesGuiMiddleware);
        }
    }
}
