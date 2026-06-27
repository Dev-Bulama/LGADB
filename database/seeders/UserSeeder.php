<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'              => 'Super Administrator',
                'email'             => 'admin@lgadb.gov.ng',
                'password'          => Hash::make('Admin@12345'),
                'role_type'         => RoleType::SuperAdmin->value,
                'is_active'         => true,
                'email_verified_at' => now(),
            ],
            [
                'name'              => 'Ibrahim Musa',
                'email'             => 'hr@lgadb.gov.ng',
                'password'          => Hash::make('Hr@12345'),
                'role_type'         => RoleType::HrOfficer->value,
                'is_active'         => true,
                'email_verified_at' => now(),
            ],
            [
                'name'              => 'Amina Bello',
                'email'             => 'manager@lgadb.gov.ng',
                'password'          => Hash::make('Manager@12345'),
                'role_type'         => RoleType::DepartmentManager->value,
                'is_active'         => true,
                'email_verified_at' => now(),
            ],
            [
                'name'              => 'Fatima Hassan',
                'email'             => 'worker@lgadb.gov.ng',
                'password'          => Hash::make('Worker@12345'),
                'role_type'         => RoleType::Worker->value,
                'is_active'         => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            $roleType = $userData['role_type'];
            unset($userData['role_type']);

            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, ['role_type' => $roleType])
            );

            // Assign Spatie role matching role_type
            $user->syncRoles([$roleType]);
        }

        $this->command->info('Demo users seeded successfully.');
    }
}
