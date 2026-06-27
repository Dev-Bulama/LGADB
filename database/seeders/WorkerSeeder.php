<?php

namespace Database\Seeders;

use App\Enums\EmploymentType;
use App\Enums\Gender;
use App\Enums\RoleType;
use App\Enums\VerificationStatus;
use App\Enums\WorkerStatus;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WorkerSeeder extends Seeder
{
    // ── Name pools ───────────────────────────────────────────────────────────────

    private array $maleFirstNames = [
        'Sani', 'Musa', 'Abubakar', 'Ibrahim', 'Usman', 'Yusuf', 'Bello',
        'Garba', 'Kabiru', 'Lawal', 'Nuhu', 'Rabiu', 'Shehu', 'Tijjani',
        'Wakili', 'Abdullahi', 'Aliyu', 'Bashir', 'Dahiru', 'Emeka',
        'Faruk', 'Habu', 'Idris', 'Jamilu', 'Kamal', 'Lawan', 'Mukhtar',
        'Nura', 'Omeiza', 'Pelu', 'Rufai', 'Salisu', 'Tanko', 'Umar',
    ];

    private array $femaleFirstNames = [
        'Fatima', 'Amina', 'Halima', 'Hauwa', 'Ramatu', 'Zainab', 'Maryam',
        'Asiya', 'Bilkisu', 'Dije', 'Hafsat', 'Khadija', 'Laraba', 'Nafisa',
        'Rakiya', 'Safiya', 'Ummi', 'Yetunde', 'Zahra', 'Aisha',
        'Bashira', 'Falmata', 'Gimbiya', 'Hadiza', 'Jummai', 'Kubra',
        'Lubabatu', 'Mairo', 'Nana', 'Sadiya',
    ];

    private array $surnames = [
        'Abubakar', 'Abdullahi', 'Aliyu', 'Bello', 'Dantani', 'Garba',
        'Hassan', 'Ibrahim', 'Isah', 'Jibril', 'Kabir', 'Lawal',
        'Muhammad', 'Musa', 'Nuhu', 'Rabiu', 'Sani', 'Shehu',
        'Umar', 'Usman', 'Yusuf', 'Zakari', 'Tanko', 'Salisu',
        'Mukhtar', 'Lawan', 'Kure', 'Idris', 'Haruna', 'Gidado',
        'Fagge', 'Emiola', 'Danladi', 'Ciroma', 'Babangida', 'Audu',
        'Adamu', 'Ahmad', 'Barau', 'Chukwu',
    ];

    private array $designations = [
        'Administrative Officer',
        'Senior Officer',
        'Principal Officer',
        'Health Inspector',
        'Teacher Grade I',
        'Agricultural Officer',
        'Accountant',
        'Revenue Officer',
        'Engineer',
        'Social Welfare Officer',
        'Security Officer',
        'Cleaner',
        'Driver',
        'Messenger',
        'Typist',
    ];

    // Units per department (department_id => [unit_id, ...])
    // Mirrors DepartmentSeeder: dept 1 → units 1-3, dept 2 → 4-6, etc.
    private array $departmentUnits = [
        1 => [1, 2, 3],
        2 => [4, 5, 6],
        3 => [7, 8, 9],
        4 => [10, 11],
        5 => [12, 13, 14],
        6 => [15, 16],
        7 => [17, 18],
        8 => [19, 20, 21],
    ];

    // ── Helpers ──────────────────────────────────────────────────────────────────

    private function randomPhone(): string
    {
        $prefixes = ['0701', '0801', '0802', '0803', '0806', '0808', '0810', '0812', '0813', '0814', '0815', '0816', '0817', '0818', '0819', '0901', '0902', '0903', '0906', '0907', '0909'];
        $prefix   = $prefixes[array_rand($prefixes)];
        return '+234' . substr($prefix, 1) . str_pad(mt_rand(0, 9999999), 7, '0', STR_PAD_LEFT);
    }

    private function uniqueVerificationCode(array &$usedCodes): string
    {
        do {
            $code = strtoupper(Str::random(10));
        } while (in_array($code, $usedCodes, true));

        $usedCodes[] = $code;
        return $code;
    }

    private function uniqueVerificationHash(array &$usedHashes): string
    {
        do {
            $hash = bin2hex(random_bytes(32));
        } while (in_array($hash, $usedHashes, true));

        $usedHashes[] = $hash;
        return $hash;
    }

    private function uniqueEmail(string $first, string $last, array &$usedEmails): string
    {
        $base  = strtolower($first . '.' . $last);
        $email = $base . '@lgadb.gov.ng';
        $idx   = 1;

        while (in_array($email, $usedEmails, true)) {
            $email = $base . $idx . '@lgadb.gov.ng';
            $idx++;
        }

        $usedEmails[] = $email;
        return $email;
    }

    // ── Run ──────────────────────────────────────────────────────────────────────

    public function run(): void
    {
        $usedCodes  = [];
        $usedHashes = [];
        $usedEmails = [];

        // Pre-seed emails already in use by demo users
        $existingEmails = User::pluck('email')->toArray();
        foreach ($existingEmails as $e) {
            $usedEmails[] = $e;
        }

        // Worker users created for first 5 workers
        $workerUserIds = [];
        for ($i = 1; $i <= 5; $i++) {
            $gender  = ($i % 2 === 0) ? 'female' : 'male';
            $surname = $this->surnames[($i - 1) % count($this->surnames)];
            $first   = $gender === 'male'
                ? $this->maleFirstNames[($i - 1) % count($this->maleFirstNames)]
                : $this->femaleFirstNames[($i - 1) % count($this->femaleFirstNames)];

            $email = $this->uniqueEmail($first, $surname, $usedEmails);

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'              => "{$first} {$surname}",
                    'password'          => Hash::make('Worker@12345'),
                    'role_type'         => RoleType::Worker->value,
                    'is_active'         => true,
                    'email_verified_at' => now(),
                ]
            );
            $user->syncRoles(['worker']);
            $workerUserIds[$i] = $user->id;
        }

        // Build 100 workers
        $workers = [];

        for ($i = 1; $i <= 100; $i++) {
            $gender = (mt_rand(0, 1) === 0) ? 'male' : 'female';

            $surname = $this->surnames[array_rand($this->surnames)];
            $first   = $gender === 'male'
                ? $this->maleFirstNames[array_rand($this->maleFirstNames)]
                : $this->femaleFirstNames[array_rand($this->femaleFirstNames)];

            $dob            = now()->subYears(mt_rand(26, 56))->subDays(mt_rand(0, 365))->toDateString();
            $departmentId   = mt_rand(1, 8);
            $unitOptions    = $this->departmentUnits[$departmentId];
            $unitId         = $unitOptions[array_rand($unitOptions)];
            $officeId       = mt_rand(1, 4);
            $wardId         = mt_rand(1, 6);
            $employmentDate = now()->subYears(mt_rand(0, 14))->subDays(mt_rand(0, 365))->toDateString();

            // Status weights: 70% active/verified, 20% pending, 10% others
            $statusRoll = mt_rand(1, 100);
            if ($statusRoll <= 35) {
                $status = WorkerStatus::Active->value;
            } elseif ($statusRoll <= 70) {
                $status = WorkerStatus::Verified->value;
            } elseif ($statusRoll <= 90) {
                $status = WorkerStatus::Pending->value;
            } else {
                $otherStatuses = [
                    WorkerStatus::Suspended->value,
                    WorkerStatus::Transferred->value,
                    WorkerStatus::Retired->value,
                ];
                $status = $otherStatuses[array_rand($otherStatuses)];
            }

            // Verification status: 70% approved, 20% pending, 10% under_review
            $vRoll = mt_rand(1, 100);
            if ($vRoll <= 70) {
                $verificationStatus = VerificationStatus::Approved->value;
                $verifiedAt         = now()->subDays(mt_rand(1, 180))->toDateTimeString();
            } elseif ($vRoll <= 90) {
                $verificationStatus = VerificationStatus::Pending->value;
                $verifiedAt         = null;
            } else {
                $verificationStatus = VerificationStatus::UnderReview->value;
                $verifiedAt         = null;
            }

            $employmentTypes  = array_column(EmploymentType::cases(), 'value');
            $employmentType   = $employmentTypes[array_rand($employmentTypes)];
            $designation      = $this->designations[array_rand($this->designations)];
            $staffNumber      = 'KNM-' . str_pad($i, 5, '0', STR_PAD_LEFT);
            $employeeNumber   = 'EMP' . str_pad($i, 6, '0', STR_PAD_LEFT);
            $verificationCode = $this->uniqueVerificationCode($usedCodes);
            $verificationHash = $this->uniqueVerificationHash($usedHashes);
            $email            = $this->uniqueEmail($first, $surname, $usedEmails);
            $idExpiryDate     = date('Y-m-d', strtotime($employmentDate . ' +2 years'));

            $nextOfKinGender     = (mt_rand(0, 1) === 0) ? 'male' : 'female';
            $nextOfKinFirstName  = $nextOfKinGender === 'male'
                ? $this->maleFirstNames[array_rand($this->maleFirstNames)]
                : $this->femaleFirstNames[array_rand($this->femaleFirstNames)];
            $nextOfKinSurname    = $this->surnames[array_rand($this->surnames)];
            $relationships       = ['Spouse', 'Parent', 'Sibling', 'Child', 'Uncle', 'Aunt'];
            $relationship        = $relationships[array_rand($relationships)];

            $emergencyFirstName = $this->maleFirstNames[array_rand($this->maleFirstNames)];
            $emergencySurname   = $this->surnames[array_rand($this->surnames)];

            $userId = $workerUserIds[$i] ?? null;

            $workers[] = [
                'uuid'                   => (string) Str::uuid(),
                'user_id'                => $userId,
                'surname'                => $surname,
                'first_name'             => $first,
                'middle_name'            => (mt_rand(0, 1) ? $this->maleFirstNames[array_rand($this->maleFirstNames)] : null),
                'gender'                 => $gender,
                'date_of_birth'          => $dob,
                'phone'                  => $this->randomPhone(),
                'email'                  => $email,
                'national_id'            => str_pad(mt_rand(0, 99999999999), 11, '0', STR_PAD_LEFT),
                'residential_address'    => mt_rand(1, 99) . ' ' . ['Fagge Road', 'Hospital Road', 'Bompai Road', 'Murtala Muhammad Way', 'Zoo Road'][array_rand(['Fagge Road', 'Hospital Road', 'Bompai Road', 'Murtala Muhammad Way', 'Zoo Road'])] . ', Kano Municipal',
                'state_id'               => 1,
                'lga_id'                 => 1,
                'ward_id'                => $wardId,
                'department_id'          => $departmentId,
                'unit_id'                => $unitId,
                'office_id'              => $officeId,
                'designation'            => $designation,
                'grade_level'            => (string) mt_rand(4, 16),
                'step'                   => (string) mt_rand(1, 15),
                'employment_type'        => $employmentType,
                'employment_date'        => $employmentDate,
                'employee_number'        => $employeeNumber,
                'staff_number'           => $staffNumber,
                'status'                 => $status,
                'verification_status'    => $verificationStatus,
                'verification_code'      => $verificationCode,
                'verification_hash'      => $verificationHash,
                'verified_at'            => $verifiedAt,
                'id_expiry_date'         => $idExpiryDate,
                'next_of_kin_name'       => "{$nextOfKinFirstName} {$nextOfKinSurname}",
                'next_of_kin_phone'      => $this->randomPhone(),
                'next_of_kin_relationship' => $relationship,
                'next_of_kin_address'    => 'Kano Municipal, Kano State',
                'emergency_contact_name' => "{$emergencyFirstName} {$emergencySurname}",
                'emergency_contact_phone' => $this->randomPhone(),
                'created_at'             => now(),
                'updated_at'             => now(),
            ];
        }

        // Insert in chunks to avoid hitting query size limits
        foreach (array_chunk($workers, 20) as $chunk) {
            DB::table('workers')->upsert(
                $chunk,
                ['staff_number'],
                [
                    'uuid', 'user_id', 'surname', 'first_name', 'middle_name', 'gender',
                    'date_of_birth', 'phone', 'email', 'national_id', 'residential_address',
                    'state_id', 'lga_id', 'ward_id', 'department_id', 'unit_id', 'office_id',
                    'designation', 'grade_level', 'step', 'employment_type', 'employment_date',
                    'employee_number', 'status', 'verification_status', 'verification_code',
                    'verification_hash', 'verified_at', 'id_expiry_date',
                    'next_of_kin_name', 'next_of_kin_phone', 'next_of_kin_relationship',
                    'next_of_kin_address', 'emergency_contact_name', 'emergency_contact_phone',
                    'updated_at',
                ]
            );
        }

        $this->command->info('100 workers seeded successfully.');
    }
}
