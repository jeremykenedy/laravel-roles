<?php

use App\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::where('name', '=', 'User')->first();
        $adminRole = Role::where('name', '=', 'Admin')->first();
        $permissions = Permission::all();

        /*
         * Add Users
         *
         */
        if (User::where('email', '=', 'admin@admin.com')->first() === null) {
            $newUser = User::create([
                'name'     => 'Admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

        if (User::where('email', '=', 'user@user.com')->first() === null) {
            $newUser = User::create([
                'name'     => 'User',
                'email'    => 'user@user.com',
                'password' => bcrypt('password'),
            ]);

            $newUser;
            $newUser->attachRole($userRole);
        }
    }
}
