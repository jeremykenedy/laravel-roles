<?php

namespace jeremykenedy\LaravelRoles\Database\Seeders;

use Illuminate\Database\Seeder;

class DefaultUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = config('roles.models.role')::where('name', '=', 'User')->first();
        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $permissions = config('roles.models.permission')::all();

        /*
         * Add Users
         *
         */
        $this->command->getOutput()->writeln('<info>Seeding:</info> DefaultUsersTableSeeder');

        if (config('roles.models.defaultUser')::where('email', '=', 'admin@admin.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
            $this->command->getOutput()->writeln(
                '<info>Seeding:</info> DefaultUsersTableSeeder - User:admin@admin.com'
            );
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'user@user.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'User',
                'email'    => 'user@user.com',
                'password' => bcrypt('password'),
            ]);

            $newUser->attachRole($userRole);
            $this->command->getOutput()->writeln('<info>Seeding:</info> DefaultUsersTableSeeder - User:user@user.com');
        }
    }
}
