<?php

namespace Database\Seeders;

use App\Models\Partition;
use Illuminate\Database\Seeder;

class PartitionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partition::truncate();

        $partitions = [
            [
                'p_number' => 'RA-P1',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P2',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P3',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P4',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P5',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P6',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P7',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P8',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P9',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P10',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P11',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P12',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P13',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P14',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P15',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P16',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'RA-P17',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B1-P1',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B1-P2',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B1-P3',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B1-P4',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B1-P5',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B1-P6',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B1-P7',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B1-P8',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B2-P1',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B2-P2',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B2-P3',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B2-P4',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B2-P5',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B2-P6',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B2-P7',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B3-P1',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B3-P2',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B3-P3',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B3-P4',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B3-P5',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B3-P6',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'B3-P7',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'BIG ROOM',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
        ];

        foreach ($partitions as $key => $value) {
            Partition::create($value);
        }
    }
}
