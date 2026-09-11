<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connection = config('roles.connection');
        $table = config('roles.permissionsRoleTable');
        $permissionsTable = config('roles.permissionsTable');
        $rolesTable = config('roles.rolesTable');

        if (Schema::connection($connection)->hasTable($table)) {
            return;
        }

        Schema::connection($connection)->create($table, function (Blueprint $table) use ($permissionsTable, $rolesTable) {
            $table->increments('id')->unsigned();
            $table->integer('permission_id')->unsigned()->index();
            $table->foreign('permission_id')->references('id')->on($permissionsTable)->onDelete('cascade');
            $table->integer('role_id')->unsigned()->index();
            $table->foreign('role_id')->references('id')->on($rolesTable)->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('roles.connection'))->dropIfExists(config('roles.permissionsRoleTable'));
    }
};
