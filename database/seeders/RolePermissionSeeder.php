<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permissions;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat Permissions
        $permissions = [
            'package_leader',
            'package_log_activity',
            'package_performance',
            'package_edit_team',
            'package_delete_team',
            'package_delete_member',
            'package_reports',
            'package_notification',
            'package_delete_task',
            'package_full_reports',
            'package_add_member',
            'package_create_task',
            'package_workload',
        ];

        foreach ($permissions as $permissionName) {
            Permissions::firstOrCreate(['name' => $permissionName]);
        }

        // Buat Roles
        $roles = [
            'admin' => [
                'package_log_activity',
                'package_performance',
                'package_edit_team',
                'package_delete_team',
                'package_delete_member',
                'package_reports',
                'package_notification',
                'package_delete_task',
                'package_workload',
            ],
            'anggota' => ['package_performance', 'package_log_activity', 'package_reports', 'package_notification', 'package_workload'],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['role_name' => $roleName]);

            $permissionIds = Permissions::whereIn('name', $rolePermissions)->pluck('id');
            $role->permissions()->sync($permissionIds);
        }

        // Output success message
        $this->command->info('Roles and Permissions seeded successfully.');
    }
}
