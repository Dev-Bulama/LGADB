<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeographySeeder extends Seeder
{
    public function run(): void
    {
        // Region
        DB::table('regions')->upsert(
            [
                [
                    'id'         => 1,
                    'name'       => 'North-West Nigeria',
                    'code'       => 'NW',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ],
            ['id'],
            ['name', 'code', 'updated_at']
        );

        // State
        DB::table('states')->upsert(
            [
                [
                    'id'         => 1,
                    'region_id'  => 1,
                    'name'       => 'Kano',
                    'code'       => 'KN',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ],
            ['id'],
            ['region_id', 'name', 'code', 'updated_at']
        );

        // LGA
        DB::table('lgas')->upsert(
            [
                [
                    'id'         => 1,
                    'state_id'   => 1,
                    'name'       => 'Kano Municipal',
                    'code'       => 'KNMC',
                    'address'    => 'Kano Municipal Local Government Secretariat',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ],
            ['id'],
            ['state_id', 'name', 'code', 'address', 'updated_at']
        );

        // Wards
        $wards = [
            ['id' => 1, 'lga_id' => 1, 'name' => 'Fagge Ward',       'code' => 'FAGGE'],
            ['id' => 2, 'lga_id' => 1, 'name' => 'Gwammaja Ward',     'code' => 'GWMJA'],
            ['id' => 3, 'lga_id' => 1, 'name' => 'Kabuga Ward',       'code' => 'KABGA'],
            ['id' => 4, 'lga_id' => 1, 'name' => 'Kofar Wambai Ward', 'code' => 'KWBAI'],
            ['id' => 5, 'lga_id' => 1, 'name' => 'Kurna Ward',        'code' => 'KURNA'],
            ['id' => 6, 'lga_id' => 1, 'name' => 'Nassarawa Ward',    'code' => 'NASSW'],
        ];

        foreach ($wards as &$ward) {
            $ward['created_at'] = now();
            $ward['updated_at'] = now();
        }

        DB::table('wards')->upsert($wards, ['id'], ['lga_id', 'name', 'code', 'updated_at']);

        $this->command->info('Geography seeded successfully.');
    }
}
