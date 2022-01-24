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
                'idorpassport' => 'OK123456',
                'whatsapp_no' => '+97102134857'
            ],
            [
                'name' => 'Selena',
                'idorpassport' => 'OK123455',
                'whatsapp_no' => '+97102134856'
            ]
        ];

        foreach ($referrers as $key => $value) {
            Referrer::create($value);
        }
    }
}
