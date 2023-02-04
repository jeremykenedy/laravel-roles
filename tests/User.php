<?php

namespace jeremykenedy\LaravelRoles\Test;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Model implements AuthorizableContract, AuthenticatableContract
{
    use Authorizable;
    use Authenticatable;
    use HasFactory;
    use HasRoleAndPermission;

    protected $guarded = [];

    protected $table = 'users';

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
