<?php

namespace Database\Seeders;

use App\Models\Floor;
use Illuminate\Database\Seeder;

class FloorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Floor::truncate();

        $floors = [
            [
                'name' => '4th Floor',
                'building_id' => 1,
            ]
        ];

        foreach ($floors as $key => $value) {
            Floor::create($value);
        }
    }
}
