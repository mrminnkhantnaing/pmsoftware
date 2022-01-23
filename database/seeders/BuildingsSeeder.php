<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Seeder;

class BuildingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Building::truncate();

        $buildings = [
            [
                'name' => 'Tower 2',
                'slug' => 'tower-2',
                'location' => 'Day To Day',
                'full_address' => 'Deira, Dubai, UAE',
            ],
        ];

        foreach ($buildings as $key => $value) {
            Building::create($value);
        }
    }
}
