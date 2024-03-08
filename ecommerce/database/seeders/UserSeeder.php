<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Arr;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign admin role
        $admin->role()->associate(Role::where('name', 'admin')->first());
        $admin->save();

        // Define regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign user role
        $user->role()->associate(Role::where('name', 'user')->first());
        $user->save();

        for ($i = 1; $i <= 10; $i++) {
            $status = rand(0, 1) ? 'user' : 'admin';

            $user = User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => bcrypt('password'),
            ]);

            // Assign a random role to the user
            $user->role()->associate(Role::where('name', $status)->first());
            $user->save();
        }
    }
}
