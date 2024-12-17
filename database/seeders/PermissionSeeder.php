<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Permissions::create([
            'name' => 'package_create_task'
        ]);
        \App\Models\Permissions::create([
            'name' => 'package_add_member'
        ]);
    }
}
