<?php

namespace jeremykenedy\LaravelRoles\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use jeremykenedy\LaravelRoles\Contracts\PermissionHasRelations as PermissionHasRelationsContract;
use jeremykenedy\LaravelRoles\Database\Database;
use jeremykenedy\LaravelRoles\Traits\PermissionHasRelations;
use jeremykenedy\LaravelRoles\Traits\Slugable;

class Permission extends Database implements PermissionHasRelationsContract
{
    use PermissionHasRelations;
    use Slugable;
    use SoftDeletes;
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'model',
    ];

    /**
     * Typecast for protection.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'name'          => 'string',
        'slug'          => 'string',
        'description'   => 'string',
        'model'         => 'string',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'deleted_at'    => 'datetime',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('roles.permissionsTable');
    }
}
