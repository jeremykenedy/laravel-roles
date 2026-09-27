<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait PermissionHasRelations
{
    /**
     * Permission belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('roles.models.role'), config('roles.permissionsRoleTable'))->withTimestamps();
    }

    /**
     * Permission belongs to many users.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('roles.models.defaultUser'), config('roles.permissionsUserTable'))->withTimestamps();
    }
}
