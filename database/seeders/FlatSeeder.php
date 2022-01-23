<?php

namespace Database\Seeders;

use App\Models\Flat;
use Illuminate\Database\Seeder;

class FlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Flat::truncate();

        $flats = [
            [
                'flat_no' => 502,
                'building_id' => 1,
                'floor_id' => 1,
            ]
        ];

        foreach ($flats as $key => $value) {
            Flat::create($value);
        }
    }
}
