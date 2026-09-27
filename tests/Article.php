<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\Test;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    protected $table = 'articles';
}
