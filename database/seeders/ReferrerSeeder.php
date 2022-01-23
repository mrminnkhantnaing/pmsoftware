<?php

namespace Database\Seeders;

use App\Models\Referrer;
use Illuminate\Database\Seeder;

class ReferrerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Referrer::truncate();

        $referrers = [
            [
                'name' => 'Dejong',
            ],
            [
                'name' => 'Hilda'
            ]
        ];

        foreach ($referrers as $key => $value) {
            Referrer::create($value);
        }
    }
}
