<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Date;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin_role = Role::where('slug', 'super-admin')->first();
        $admin_role = Role::where('slug', 'admin')->first();
        $cashier_role = Role::where('slug', 'cashier')->first();

        $user = User::create([
                'first_name' => 'Super',
                'last_name' => "Admin",
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => $this->freshTimestamp(),
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp(),
            ]);
        $user->roles()->attach($super_admin_role);

        $user = User::create([
                'first_name' => 'Admin',
                'last_name' => "Admin",
                'email' => 'aadmin@gmail.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => $this->freshTimestamp(),
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp(),
            ]);
        $user->roles()->attach($admin_role);
        
        $user = User::create([
                'first_name' => 'Cashier',
                'last_name' => "User",
                'email' => 'cashier@gmail.com',
                'password' => Hash::make('cashier123'),
                'email_verified_at' => $this->freshTimestamp(),
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp(),
            ]);
        $user->roles()->attach($cashier_role);
    }

    /**
     * Get a fresh timestamp for the model.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function freshTimestamp()
    {
        return Date::now();
    }
}
