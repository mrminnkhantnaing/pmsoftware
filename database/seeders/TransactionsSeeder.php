<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::truncate();

        $transactions = [
            [
                'invoice_no' => '1000000001',
                'invoice_prefix' => 'AA',
                'invoice_status' => 'fully_paid',
                'invoice_type' => 'payment',
                'tenant_id' => 39,
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
                'partition_id' => 19,
                'no_of_tenant' => 1,
                'start_date' => now()->subMonth()->addDays(20),
                'end_date' => now()->addDays(20),
                'price' => '1000',
                'currency' => 'AED',
                'sub_total' => '1000',
                'total_price' => '1000',
                'payment_amount' => '700',
                'balance' => '300',
                'created_at' => now()->subMonth()->addDays(20),
                'updated_at' => now()->subMonth()->addDays(20),
            ],
            [
                'invoice_no' => '1000000002',
                'invoice_prefix' => 'AA',
                'invoice_status' => 'fully_paid',
                'invoice_type' => 'payment',
                'tenant_id' => 38,
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
                'partition_id' => 14,
                'no_of_tenant' => 1,
                'start_date' => now()->subMonth()->addDays(15),
                'end_date' => now()->addDays(15),
                'price' => '1100',
                'currency' => 'AED',
                'sub_total' => '1100',
                'total_price' => '1100',
                'payment_amount' => '600',
                'balance' => '500',
                'created_at' => now()->subMonth()->addDays(15),
                'updated_at' => now()->subMonth()->addDays(15),
            ],
            [
                'invoice_no' => '1000000003',
                'invoice_prefix' => 'AA',
                'invoice_status' => 'fully_paid',
                'invoice_type' => 'payment',
                'tenant_id' => 37,
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
                'partition_id' => 10,
                'no_of_tenant' => 1,
                'start_date' => now()->subMonth()->addDays(15),
                'end_date' => now()->addDays(15),
                'price' => '900',
                'currency' => 'AED',
                'sub_total' => '900',
                'total_price' => '900',
                'payment_amount' => '900',
                'balance' => '0',
                'created_at' => now()->subMonth()->addDays(15),
                'updated_at' => now()->subMonth()->addDays(15),
            ],
            [
                'invoice_no' => '1000000004',
                'invoice_prefix' => 'AA',
                'invoice_status' => 'fully_paid',
                'invoice_type' => 'payment',
                'tenant_id' => 36,
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
                'partition_id' => 7,
                'no_of_tenant' => 1,
                'start_date' => now()->subMonth()->addDays(4),
                'end_date' => now()->addDays(4),
                'price' => '800',
                'currency' => 'AED',
                'sub_total' => '800',
                'total_price' => '800',
                'payment_amount' => '800',
                'balance' => '0',
                'created_at' => now()->subMonth()->addDays(4),
                'updated_at' => now()->subMonth()->addDays(4),
            ],
            [
                'invoice_no' => '1000000005',
                'invoice_prefix' => 'AA',
                'invoice_status' => 'fully_paid',
                'invoice_type' => 'payment',
                'tenant_id' => 35,
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
                'partition_id' => 3,
                'no_of_tenant' => 1,
                'start_date' => now()->subMonth()->addDays(3),
                'end_date' => now()->addDays(3),
                'price' => '700',
                'currency' => 'AED',
                'sub_total' => '700',
                'total_price' => '700',
                'payment_amount' => '700',
                'balance' => '0',
                'created_at' => now()->subMonth()->addDays(3),
                'updated_at' => now()->subMonth()->addDays(3),
            ],
            [
                'invoice_no' => '1000000006',
                'invoice_prefix' => 'AA',
                'invoice_status' => 'fully_paid',
                'invoice_type' => 'payment',
                'tenant_id' => 34,
                'building_id' => 1,
                'floor_id' => 1,
                'flat_id' => 1,
                'partition_id' => 1,
                'no_of_tenant' => 1,
                'start_date' => now()->subMonth()->subDays(5),
                'end_date' => now()->subDays(5),
                'price' => '700',
                'currency' => 'AED',
                'sub_total' => '700',
                'total_price' => '700',
                'payment_amount' => '700',
                'balance' => '0',
                'created_at' => now()->subMonth()->subDays(5),
                'updated_at' => now()->subMonth()->subDays(5),
            ]
        ];

        foreach ($transactions as $key => $value) {
            Transaction::create($value);
        }
    }
}
