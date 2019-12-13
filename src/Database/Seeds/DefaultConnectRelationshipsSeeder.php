<?php

namespace jeremykenedy\LaravelRoles\Database\Seeds;

use Illuminate\Database\Seeder;

class DefaultConnectRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Get Available Permissions.
         */
        $permissions = config('roles.models.permission')::all();

        /**
         * Attach Permissions to Roles.
         */
        $roleAdmin = config('roles.models.role')::where('slug', '=', 'admin')->first()
            ?? config('roles.models.role')::where('name', '=', 'Admin')->first();

        echo "\e[32mSeeding:\e[0m DefaultConnectRelationshipsSeeder\r\n";
        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);
            echo "\e[32mSeeding:\e[0m DefaultConnectRelationshipsSeeder - Role:Admin attached to Permission:".$permission->slug."\r\n";
        }
    }
}
