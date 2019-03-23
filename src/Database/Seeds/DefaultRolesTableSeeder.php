<?php

namespace jeremykenedy\LaravelRoles\Database\Seeds;

use Illuminate\Database\Seeder;

class DefaultRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'Admin Role',
                'level'       => 5,
            ],
            [
                'name'        => 'User',
                'slug'        => 'user',
                'description' => 'User Role',
                'level'       => 1,
            ],
            [
                'name'        => 'Unverified',
                'slug'        => 'unverified',
                'description' => 'Unverified Role',
                'level'       => 0,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        echo "\e[32mSeeding:\e[0m DefaultRoleItemsTableSeeder\r\n";
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = config('roles.models.role')::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = config('roles.models.role')::create([
                    'name'          => $RoleItem['name'],
                    'slug'          => $RoleItem['slug'],
                    'description'   => $RoleItem['description'],
                    'level'         => $RoleItem['level'],
                ]);
                echo "\e[32mSeeding:\e[0m DefaultRoleItemsTableSeeder - Role:".$RoleItem['slug']."\r\n";
            }
        }
    }
}
