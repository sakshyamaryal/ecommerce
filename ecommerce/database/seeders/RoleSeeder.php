<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define roles
        $roles = [
            ['name' => 'admin'],
            ['name' => 'user']
            // Add more roles if needed
        ];

        // Insert roles into the database
        Role::insert($roles);
    }
}
