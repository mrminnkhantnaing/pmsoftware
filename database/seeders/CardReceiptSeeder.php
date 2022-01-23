<?php

namespace Database\Seeders;

use App\Models\CardReceipt;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CardReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CardReceipt::truncate();

        $buildings = [
            [
                'tenant_id' => 1,
                'card_id' => 1,
                'card_price' => '50',
                'currency' => 'AED',
                'receipt_status' => 'issued',
                'issued_date' => Carbon::now()->subDays(8)->toDateTimeString(),
                'returned_date' => null,
                'from_transaction' => 1,
                'created_at' => Carbon::now()->subDays(8)->toDateTimeString(),
            ],
            [
                'tenant_id' => 2,
                'card_id' => 2,
                'card_price' => '50',
                'currency' => 'AED',
                'receipt_status' => 'issued',
                'issued_date' => Carbon::now()->subDays(20)->toDateTimeString(),
                'returned_date' => null,
                'from_transaction' => 1,
                'created_at' => Carbon::now()->subDays(20)->toDateTimeString(),
            ],
        ];

        foreach ($buildings as $key => $value) {
            CardReceipt::create($value);
        }
    }
}
