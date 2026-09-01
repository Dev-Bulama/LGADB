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
            ['id' =>  1, 'name' => 'Finance & Accounts',                'code' => 'FIN'],
            ['id' =>  2, 'name' => 'Health Services',                   'code' => 'HLT'],
            ['id' =>  3, 'name' => 'Education',                         'code' => 'EDU'],
            ['id' =>  4, 'name' => 'Works & Infrastructure',            'code' => 'WRK'],
            ['id' =>  5, 'name' => 'Agriculture & Natural Resources',   'code' => 'AGR'],
            ['id' =>  6, 'name' => 'Social Welfare',                    'code' => 'SOC'],
            ['id' =>  7, 'name' => 'Security & Civil Defense',          'code' => 'SEC'],
            ['id' =>  8, 'name' => 'Administration & Human Resources',  'code' => 'ADM'],
            ['id' =>  9, 'name' => 'Legal & Compliance',                'code' => 'LGL'],
            ['id' => 10, 'name' => 'Planning, Research & Statistics',   'code' => 'PRS'],
            ['id' => 11, 'name' => 'Environment & Sanitation',          'code' => 'ENV'],
            ['id' => 12, 'name' => 'Community Development',             'code' => 'COM'],
            ['id' => 13, 'name' => 'Information & Communications',      'code' => 'ICT'],
            ['id' => 14, 'name' => 'Youth & Sports Development',        'code' => 'YSD'],
            ['id' => 15, 'name' => 'Women Affairs & Gender',            'code' => 'WAG'],
            ['id' => 16, 'name' => 'Market & Trade Development',        'code' => 'MTD'],
            ['id' => 17, 'name' => 'Land & Housing',                    'code' => 'LHD'],
            ['id' => 18, 'name' => 'Transport & Traffic Management',    'code' => 'TTM'],
            ['id' => 19, 'name' => 'Cultural Affairs & Tourism',        'code' => 'CAT'],
            ['id' => 20, 'name' => 'Others',                            'code' => 'OTH'],
        ];

        foreach ($departments as &$dept) {
            $dept['lga_id']     = 1;
            $dept['slug']       = Str::slug($dept['name']);
            $dept['is_active']  = true;
            $dept['created_at'] = now();
            $dept['updated_at'] = now();
        }

        DB::table('departments')->upsert(
            $departments,
            ['id'],
            ['name', 'code', 'slug', 'is_active', 'updated_at']
        );

        // ── Units ────────────────────────────────────────────────────────────────
        $units = [
            // Finance & Accounts (dept 1)
            ['department_id' =>  1, 'name' => 'Budgeting & Planning',      'code' => 'FIN-BP'],
            ['department_id' =>  1, 'name' => 'Revenue Collection',        'code' => 'FIN-RC'],
            ['department_id' =>  1, 'name' => 'Payroll & Salaries',        'code' => 'FIN-PS'],
            ['department_id' =>  1, 'name' => 'Internal Audit',            'code' => 'FIN-IA'],

            // Health Services (dept 2)
            ['department_id' =>  2, 'name' => 'Primary Health Care',       'code' => 'HLT-PHC'],
            ['department_id' =>  2, 'name' => 'Environmental Health',      'code' => 'HLT-EH'],
            ['department_id' =>  2, 'name' => 'Disease Control',           'code' => 'HLT-DC'],
            ['department_id' =>  2, 'name' => 'Maternal & Child Health',   'code' => 'HLT-MCH'],

            // Education (dept 3)
            ['department_id' =>  3, 'name' => 'Primary Education',         'code' => 'EDU-PE'],
            ['department_id' =>  3, 'name' => 'Adult & Non-Formal Ed.',    'code' => 'EDU-AE'],
            ['department_id' =>  3, 'name' => 'Scholarship & Bursary',     'code' => 'EDU-SB'],
            ['department_id' =>  3, 'name' => 'School Inspection',         'code' => 'EDU-SI'],

            // Works & Infrastructure (dept 4)
            ['department_id' =>  4, 'name' => 'Roads & Drainage',          'code' => 'WRK-RD'],
            ['department_id' =>  4, 'name' => 'Buildings & Estates',       'code' => 'WRK-BE'],
            ['department_id' =>  4, 'name' => 'Water Supply',              'code' => 'WRK-WS'],

            // Agriculture & Natural Resources (dept 5)
            ['department_id' =>  5, 'name' => 'Crop Production',           'code' => 'AGR-CP'],
            ['department_id' =>  5, 'name' => 'Livestock & Fisheries',     'code' => 'AGR-LF'],
            ['department_id' =>  5, 'name' => 'Agricultural Extension',    'code' => 'AGR-AE'],

            // Social Welfare (dept 6)
            ['department_id' =>  6, 'name' => 'Vulnerable Persons Care',   'code' => 'SOC-VP'],
            ['department_id' =>  6, 'name' => 'Disability Affairs',        'code' => 'SOC-DA'],
            ['department_id' =>  6, 'name' => 'Orphanage & Foster Care',   'code' => 'SOC-FC'],

            // Security & Civil Defense (dept 7)
            ['department_id' =>  7, 'name' => 'Civil Defense Unit',        'code' => 'SEC-CD'],
            ['department_id' =>  7, 'name' => 'Emergency Services',        'code' => 'SEC-ES'],

            // Administration & HR (dept 8)
            ['department_id' =>  8, 'name' => 'Human Resources',           'code' => 'ADM-HR'],
            ['department_id' =>  8, 'name' => 'Records Management',        'code' => 'ADM-RM'],
            ['department_id' =>  8, 'name' => 'Procurement',               'code' => 'ADM-PR'],
            ['department_id' =>  8, 'name' => 'Protocol & Correspondence', 'code' => 'ADM-PC'],

            // Legal & Compliance (dept 9)
            ['department_id' =>  9, 'name' => 'Legal Advisory',            'code' => 'LGL-LA'],
            ['department_id' =>  9, 'name' => 'Litigation',                'code' => 'LGL-LT'],

            // Planning, Research & Statistics (dept 10)
            ['department_id' => 10, 'name' => 'Research & Development',    'code' => 'PRS-RD'],
            ['department_id' => 10, 'name' => 'Statistics & Data',         'code' => 'PRS-SD'],

            // Environment & Sanitation (dept 11)
            ['department_id' => 11, 'name' => 'Waste Management',          'code' => 'ENV-WM'],
            ['department_id' => 11, 'name' => 'Pollution Control',         'code' => 'ENV-PC'],

            // Community Development (dept 12)
            ['department_id' => 12, 'name' => 'Community Liaison',         'code' => 'COM-CL'],
            ['department_id' => 12, 'name' => 'NGO Relations',             'code' => 'COM-NG'],

            // ICT (dept 13)
            ['department_id' => 13, 'name' => 'IT Infrastructure',         'code' => 'ICT-IT'],
            ['department_id' => 13, 'name' => 'Digital Services',          'code' => 'ICT-DS'],

            // Youth & Sports (dept 14)
            ['department_id' => 14, 'name' => 'Youth Empowerment',         'code' => 'YSD-YE'],
            ['department_id' => 14, 'name' => 'Sports Development',        'code' => 'YSD-SD'],

            // Women Affairs (dept 15)
            ['department_id' => 15, 'name' => 'Gender Mainstreaming',      'code' => 'WAG-GM'],
            ['department_id' => 15, 'name' => 'Women Empowerment',         'code' => 'WAG-WE'],

            // Market & Trade (dept 16)
            ['department_id' => 16, 'name' => 'Market Administration',     'code' => 'MTD-MA'],
            ['department_id' => 16, 'name' => 'Trade Licensing',           'code' => 'MTD-TL'],

            // Land & Housing (dept 17)
            ['department_id' => 17, 'name' => 'Land Registry',             'code' => 'LHD-LR'],
            ['department_id' => 17, 'name' => 'Housing Development',       'code' => 'LHD-HD'],

            // Transport (dept 18)
            ['department_id' => 18, 'name' => 'Traffic Management',        'code' => 'TTM-TM'],
            ['department_id' => 18, 'name' => 'Vehicle Licensing',         'code' => 'TTM-VL'],

            // Cultural Affairs (dept 19)
            ['department_id' => 19, 'name' => 'Cultural Programmes',       'code' => 'CAT-CP'],
            ['department_id' => 19, 'name' => 'Tourism Promotion',         'code' => 'CAT-TP'],

            // Others (dept 20)
            ['department_id' => 20, 'name' => 'General Services',          'code' => 'OTH-GS'],
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
        $secretariat = 'Ayobo Ipaja LCDA Secretariat, Ipaja Road, Ayobo, Lagos';

        $offices = [
            [
                'id'            => 1,
                'lga_id'        => 1,
                'department_id' => null,
                'name'          => 'Main Secretariat',
                'code'          => 'OFF-MAIN',
                'address'       => $secretariat,
            ],
            [
                'id'            => 2,
                'lga_id'        => 1,
                'department_id' => 2,
                'name'          => 'Primary Health Care Centre',
                'code'          => 'OFF-HLT',
                'address'       => 'PHC Building, Ayobo Road, Ayobo Ipaja LCDA, Lagos',
            ],
            [
                'id'            => 3,
                'lga_id'        => 1,
                'department_id' => 3,
                'name'          => 'Education Department Office',
                'code'          => 'OFF-EDU',
                'address'       => 'Education Block, ' . $secretariat,
            ],
            [
                'id'            => 4,
                'lga_id'        => 1,
                'department_id' => 5,
                'name'          => 'Agricultural Extension Office',
                'code'          => 'OFF-AGR',
                'address'       => 'Agricultural Block, Meiran Road, Ayobo Ipaja LCDA, Lagos',
            ],
            [
                'id'            => 5,
                'lga_id'        => 1,
                'department_id' => 11,
                'name'          => 'Environment & Sanitation Office',
                'code'          => 'OFF-ENV',
                'address'       => 'Environment Block, ' . $secretariat,
            ],
            [
                'id'            => 6,
                'lga_id'        => 1,
                'department_id' => 13,
                'name'          => 'ICT / Digital Services Centre',
                'code'          => 'OFF-ICT',
                'address'       => 'ICT Unit, ' . $secretariat,
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
