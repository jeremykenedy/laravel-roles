<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\Database;

use Illuminate\Database\Eloquent\Model;

abstract class Database extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection;

    /**
     * Create a new instance to set the table and connection.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($connection = config('roles.connection')) {
            $this->connection = $connection;
        }
    }

    /**
     * Get the database connection.
     *
     * @return string|null
     */
    public function getConnectionName()
    {
        return $this->connection;
    }

    /**
     * Get the database table.
     *
     * @return string|null
     */
    public function getTableName()
    {
        return $this->table;
    }
}
