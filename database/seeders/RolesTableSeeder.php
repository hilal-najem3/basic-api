<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'super-admin',
                'slug' => 'super-admin'
            ],
            [
                'name' => 'admin',
                'slug' => 'admin'
            ],
            [
                'name' => 'super-visor',
                'slug' => 'super-visor'
            ],
            [
                'name' => 'manager',
                'slug' => 'manager'
            ],
            [
                'name' => 'cashier',
                'slug' => 'cashier'
            ],
            [
                'name' => 'client',
                'slug' => 'client'
            ]
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
