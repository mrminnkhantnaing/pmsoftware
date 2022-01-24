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
                'company_name' => 'PM Software',
                'company_phone_no' => '0598765432',
                'company_email' => 'info@pmsoftware.xyz',
                'company_address' => 'Al Rigga Street, Deira, Dubai, UAE',
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
