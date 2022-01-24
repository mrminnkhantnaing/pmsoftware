<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);

        $this->call(BuildingsSeeder::class);
        $this->call(FloorsSeeder::class);
        $this->call(FlatSeeder::class);
        $this->call(PartitionsSeeder::class);
        $this->call(TenantsSeeder::class);


        $this->call(ReferrerSeeder::class);

        $this->call(TransactionsSeeder::class);
        // $this->call(CardReceiptSeeder::class);

        \App\Models\Card::factory(200)->create();
        \App\Models\Note::factory(10)->create();
    }
}
