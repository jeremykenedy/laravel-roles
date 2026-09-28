<?php

namespace jeremykenedy\LaravelRoles\App\Http\Requests\Concerns;

trait ChecksConfiguredAccess
{
    /**
     * Decide whether the current user passes the configured gate.
     *
     * An empty type means no extra gate was configured. Any other value that
     * is not a role or permission check is refused, so a misspelled setting
     * closes the form instead of opening it to everyone.
     *
     * @param string|null $type
     * @param string|null $required
     *
     * @return bool
     */
    protected function passesConfiguredGate($type, $required)
    {
        if ($type === null || $type === '') {
            return true;
        }

        $user = $this->user();

        if ($user === null) {
            return false;
        }

        switch ($type) {
            case 'role':
            case 'roles':
                return (bool) $user->hasRole($required);
            case 'permission':
            case 'permissions':
                return (bool) $user->hasPermission($required);
        }

        return false;
    }
}
