<?php

namespace jeremykenedy\LaravelRoles\Database\Seeders;

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

        $this->command->getOutput()->writeln('<info>Seeding:</info> DefaultConnectRelationshipsSeeder');
        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);
            $this->command->getOutput()->writeln(
                '<info>Seeding:</info> DefaultConnectRelationshipsSeeder - Role:Admin attached to Permission:'
                .$permission->slug
            );
        }
    }
}
