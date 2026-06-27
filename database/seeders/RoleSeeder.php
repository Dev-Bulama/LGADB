<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Workers
            'manage-workers',
            'view-workers',
            'create-workers',
            'edit-workers',
            'delete-workers',
            'verify-workers',

            // Departments / Units / Offices
            'manage-departments',
            'manage-units',
            'manage-offices',

            // Users & Settings
            'manage-users',
            'manage-settings',

            // Reports
            'manage-reports',
            'view-reports',
            'export-reports',

            // Content
            'manage-announcements',
            'manage-faqs',
            'manage-pages',

            // ID Cards
            'manage-id-cards',
            'generate-id-cards',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Super Admin – all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // HR Officer – worker verification + view + generate ID cards
        $hrOfficer = Role::firstOrCreate(['name' => 'hr_officer', 'guard_name' => 'web']);
        $hrOfficer->syncPermissions([
            'manage-workers',
            'view-workers',
            'create-workers',
            'edit-workers',
            'verify-workers',
            'view-reports',
            'export-reports',
            'generate-id-cards',
            'manage-id-cards',
        ]);

        // Department Manager – view workers + view reports
        $departmentManager = Role::firstOrCreate(['name' => 'department_manager', 'guard_name' => 'web']);
        $departmentManager->syncPermissions([
            'view-workers',
            'view-reports',
        ]);

        // Worker – minimal read access
        Role::firstOrCreate(['name' => 'worker', 'guard_name' => 'web']);

        $this->command->info('Roles and permissions seeded successfully.');
    }
}
