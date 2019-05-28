<?php

namespace jeremykenedy\LaravelRoles\Traits;

trait RolesUsageAuthTrait
{
    /**
     * Variable to hold if we are using built in Laravel authentication.
     */
    private $_rolesGuiAuthEnabled;

    /**
     * Variable to hold if we are using roles/permissoins middleware for access.
     */
    private $_rolesGuiMiddlewareEnabled;

    /**
     * Variable to hold what roles/permissions middleware we are using if enabled.
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

        if ($this->_rolesGuiAuthEnabled) {
            $this->middleware('auth');
        }

        if ($this->_rolesGuiMiddlewareEnabled) {
            $this->middleware($this->_rolesGuiMiddleware);
        }
    }
}
