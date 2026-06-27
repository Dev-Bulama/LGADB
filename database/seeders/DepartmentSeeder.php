<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        // ── Departments ─────────────────────────────────────────────────────────
        $departments = [
            ['id' => 1, 'name' => 'Finance & Accounts',             'code' => 'FIN'],
            ['id' => 2, 'name' => 'Health Services',                'code' => 'HLT'],
            ['id' => 3, 'name' => 'Education',                      'code' => 'EDU'],
            ['id' => 4, 'name' => 'Works & Infrastructure',         'code' => 'WRK'],
            ['id' => 5, 'name' => 'Agriculture & Natural Resources', 'code' => 'AGR'],
            ['id' => 6, 'name' => 'Social Welfare',                 'code' => 'SOC'],
            ['id' => 7, 'name' => 'Security & Civil Defense',       'code' => 'SEC'],
            ['id' => 8, 'name' => 'Administration & HR',            'code' => 'ADM'],
        ];

        foreach ($departments as &$dept) {
            $dept['lga_id']      = 1;
            $dept['slug']        = Str::slug($dept['name']);
            $dept['is_active']   = true;
            $dept['created_at']  = now();
            $dept['updated_at']  = now();
        }

        DB::table('departments')->upsert(
            $departments,
            ['id'],
            ['name', 'code', 'slug', 'is_active', 'updated_at']
        );

        // ── Units (2-3 per department) ───────────────────────────────────────────
        $units = [
            // Finance & Accounts (dept 1)
            ['department_id' => 1, 'name' => 'Budgeting & Planning', 'code' => 'FIN-BP'],
            ['department_id' => 1, 'name' => 'Revenue Collection',   'code' => 'FIN-RC'],
            ['department_id' => 1, 'name' => 'Payroll & Salaries',   'code' => 'FIN-PS'],

            // Health Services (dept 2)
            ['department_id' => 2, 'name' => 'Primary Health Care',  'code' => 'HLT-PHC'],
            ['department_id' => 2, 'name' => 'Environmental Health',  'code' => 'HLT-EH'],
            ['department_id' => 2, 'name' => 'Disease Control',       'code' => 'HLT-DC'],

            // Education (dept 3)
            ['department_id' => 3, 'name' => 'Primary Education',    'code' => 'EDU-PE'],
            ['department_id' => 3, 'name' => 'Adult Education',      'code' => 'EDU-AE'],
            ['department_id' => 3, 'name' => 'Scholarship Board',    'code' => 'EDU-SB'],

            // Works & Infrastructure (dept 4)
            ['department_id' => 4, 'name' => 'Roads & Drainage',     'code' => 'WRK-RD'],
            ['department_id' => 4, 'name' => 'Buildings & Estates',  'code' => 'WRK-BE'],

            // Agriculture & Natural Resources (dept 5)
            ['department_id' => 5, 'name' => 'Crop Production',      'code' => 'AGR-CP'],
            ['department_id' => 5, 'name' => 'Livestock & Fisheries','code' => 'AGR-LF'],
            ['department_id' => 5, 'name' => 'Agricultural Extension','code' => 'AGR-AE'],

            // Social Welfare (dept 6)
            ['department_id' => 6, 'name' => 'Women Affairs',        'code' => 'SOC-WA'],
            ['department_id' => 6, 'name' => 'Youth Development',    'code' => 'SOC-YD'],

            // Security & Civil Defense (dept 7)
            ['department_id' => 7, 'name' => 'Civil Defense Unit',   'code' => 'SEC-CD'],
            ['department_id' => 7, 'name' => 'Emergency Services',   'code' => 'SEC-ES'],

            // Administration & HR (dept 8)
            ['department_id' => 8, 'name' => 'Human Resources',      'code' => 'ADM-HR'],
            ['department_id' => 8, 'name' => 'Records Management',   'code' => 'ADM-RM'],
            ['department_id' => 8, 'name' => 'Procurement',          'code' => 'ADM-PR'],
        ];

        foreach ($units as $index => &$unit) {
            $unit['id']          = $index + 1;
            $unit['is_active']   = true;
            $unit['created_at']  = now();
            $unit['updated_at']  = now();
        }

        DB::table('units')->upsert(
            $units,
            ['id'],
            ['department_id', 'name', 'code', 'is_active', 'updated_at']
        );

        // ── Offices ─────────────────────────────────────────────────────────────
        $offices = [
            [
                'id'            => 1,
                'lga_id'        => 1,
                'department_id' => null,
                'name'          => 'Main Secretariat',
                'code'          => 'OFF-MAIN',
                'address'       => 'Kano Municipal LGA Secretariat, Hospital Road, Kano',
            ],
            [
                'id'            => 2,
                'lga_id'        => 1,
                'department_id' => 2,
                'name'          => 'Health Centre',
                'code'          => 'OFF-HLT',
                'address'       => 'Primary Health Care Centre, Fagge, Kano Municipal',
            ],
            [
                'id'            => 3,
                'lga_id'        => 1,
                'department_id' => 3,
                'name'          => 'Education Department Building',
                'code'          => 'OFF-EDU',
                'address'       => 'Education Block, Kano Municipal LGA Secretariat',
            ],
            [
                'id'            => 4,
                'lga_id'        => 1,
                'department_id' => 5,
                'name'          => 'Agricultural Extension Office',
                'code'          => 'OFF-AGR',
                'address'       => 'Agricultural Extension Building, Nassarawa, Kano Municipal',
            ],
        ];

        foreach ($offices as &$office) {
            $office['is_active']  = true;
            $office['created_at'] = now();
            $office['updated_at'] = now();
        }

        DB::table('offices')->upsert(
            $offices,
            ['id'],
            ['lga_id', 'department_id', 'name', 'code', 'address', 'is_active', 'updated_at']
        );

        $this->command->info('Departments, units, and offices seeded successfully.');
    }
}
