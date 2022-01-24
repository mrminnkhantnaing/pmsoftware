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
                'p_number' => 'AA-P1',
                'status' => 'occupied',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P2',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P3',
                'status' => 'occupied',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P4',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P5',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P6',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P7',
                'status' => 'occupied',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P8',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P9',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P10',
                'status' => 'occupied',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P11',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P12',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P13',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P14',
                'status' => 'occupied',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P15',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P16',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'AA-P17',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'BB-P1',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'BB-P2',
                'status' => 'occupied',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'BB-P3',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'BB-P4',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'BB-P5',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'BB-P6',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'BB-P7',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'BB-P8',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'CC-P1',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'CC-P2',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'CC-P3',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'CC-P4',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'CC-P5',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'CC-P6',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'CC-P7',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'DD-P1',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'DD-P2',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'DD-P3',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'DD-P4',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'DD-P5',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'DD-P6',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'DD-P7',
                'status' => 'available',
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
            ],
            [
                'p_number' => 'EE-P1',
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
