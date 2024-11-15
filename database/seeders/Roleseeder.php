<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::create([
            'role_name' => 'anggota'
        ]);

        \App\Models\Role::create([
            'role_name' => 'admin'
        ]);

        \App\Models\Role::create([
            'role_name' => 'manager'
        ]);
    }
}
