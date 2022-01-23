<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();

        $settings = [
            [
                'company_name' => 'MSHT Facilities Management',
                'company_phone_no' => '0504306534',
                'company_email' => 'info@msht.com',
                'company_address' => 'Omar Bin Al Khattab St, Deira, Dubai',
                'invoice_prefix' => 'AA',
                'invoice_theme_color' => '#E7A602',
                'currency' => 'AED',
                'card_price' => 50,
                'termsnconditions' => 'You need to give one month notice before leaving the partition. <br>Drinking & smoking are not allowed inside the partition. <br>Visitors are only allowed in the weekends.',
            ],
        ];

        foreach ($settings as $key => $value) {
            Setting::create($value);
        }
    }
}
