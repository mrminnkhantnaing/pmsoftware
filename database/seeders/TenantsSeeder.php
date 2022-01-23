<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tenant::truncate();

        $tenants = [
            [
                'name' => 'HANNAH',
                'idorpassport' => 'PP000001',
                'whatsapp_no' => '0529528339',
                'phone_no' => '0529528339',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 500,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'ASMA',
                'idorpassport' => 'PP000002',
                'whatsapp_no' => '0558226594',
                'phone_no' => '0558226594',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'ANAND',
                'idorpassport' => 'PP000003',
                'whatsapp_no' => '0526387810',
                'phone_no' => '0526387810',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 500,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'BERNANIE',
                'idorpassport' => 'PP000004',
                'whatsapp_no' => '0544068487',
                'phone_no' => '0544068487',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JANE',
                'idorpassport' => 'PP000005',
                'whatsapp_no' => '0505155943',
                'phone_no' => '0505155943',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'CAROL',
                'idorpassport' => 'PP000006',
                'whatsapp_no' => '0565768801',
                'phone_no' => '0565768801',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 400,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'SITTI',
                'idorpassport' => 'PP000007',
                'whatsapp_no' => '0556652427',
                'phone_no' => '0556652427',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 100,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'SHIRLEY',
                'idorpassport' => 'PP000008',
                'whatsapp_no' => '0569363724',
                'phone_no' => '0569363724',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 300,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JEYSON',
                'idorpassport' => 'PP000009',
                'whatsapp_no' => '0508764258',
                'phone_no' => '0508764258',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JOY',
                'idorpassport' => 'PP000010',
                'whatsapp_no' => '0567430319',
                'phone_no' => '0567430319',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 500,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'SUHIL',
                'idorpassport' => 'PP000011',
                'whatsapp_no' => '0555434874',
                'phone_no' => '0555434874',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 400,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'SPENCER',
                'idorpassport' => 'PP000012',
                'whatsapp_no' => '0563667030',
                'phone_no' => '0563667030',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 340,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'BALOT',
                'idorpassport' => 'PP000013',
                'whatsapp_no' => '562581975',
                'phone_no' => '562581975',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 400,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JAY',
                'idorpassport' => 'PP000014',
                'whatsapp_no' => '0553632415',
                'phone_no' => '0553632415',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 300,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JANA',
                'idorpassport' => 'PP000015',
                'whatsapp_no' => '0563001682',
                'phone_no' => '0563001682',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 400,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'GAJIE',
                'idorpassport' => 'PP000016',
                'whatsapp_no' => '0553570314',
                'phone_no' => '0553570314',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 500,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'MARKY',
                'idorpassport' => 'PP000017',
                'whatsapp_no' => '0567603518',
                'phone_no' => '0567603518',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'LEA',
                'idorpassport' => 'PP000018',
                'whatsapp_no' => '0559614458',
                'phone_no' => '0559614458',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 200,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'THUSHANTA',
                'idorpassport' => 'PP000019',
                'whatsapp_no' => '0565745685',
                'phone_no' => '0565745685',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'HNIN',
                'idorpassport' => 'PP000020',
                'whatsapp_no' => '0589374431',
                'phone_no' => '0589374431',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'MARITES',
                'idorpassport' => 'PP000021',
                'whatsapp_no' => '0504841395',
                'phone_no' => '0504841395',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 400,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'MARY',
                'idorpassport' => 'PP000022',
                'whatsapp_no' => '0524202960',
                'phone_no' => '0524202960',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'AANA',
                'idorpassport' => 'PP000023',
                'whatsapp_no' => '0566019458',
                'phone_no' => '0566019458',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'ELIS',
                'idorpassport' => 'PP000024',
                'whatsapp_no' => '0588841996',
                'phone_no' => '0588841996',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JENNY',
                'idorpassport' => 'PP000025',
                'whatsapp_no' => '0568507506',
                'phone_no' => '0568507506',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 200,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'ZHELL',
                'idorpassport' => 'PP000026',
                'whatsapp_no' => '0543619288',
                'phone_no' => '0543619288',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JAY',
                'idorpassport' => 'PP000027',
                'whatsapp_no' => '0501653054',
                'phone_no' => '0501653054',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 200,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'PIA',
                'idorpassport' => 'PP000028',
                'whatsapp_no' => '05504057965',
                'phone_no' => '05504057965',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 500,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'GHULAM',
                'idorpassport' => 'PP000029',
                'whatsapp_no' => '0552853865',
                'phone_no' => '0552853865',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 400,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JOCELYN',
                'idorpassport' => 'PP000030',
                'whatsapp_no' => '0558154919',
                'phone_no' => '0558154919',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JOSIE',
                'idorpassport' => 'PP000031',
                'whatsapp_no' => '0501108060',
                'phone_no' => '0501108060',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 200,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JANISH',
                'idorpassport' => 'PP000032',
                'whatsapp_no' => '0525592704',
                'phone_no' => '0525592704',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JR',
                'idorpassport' => 'PP000033',
                'whatsapp_no' => '0527622238',
                'phone_no' => '0527622238',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 100,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'MARICEL',
                'idorpassport' => 'PP000034',
                'whatsapp_no' => '0558153496',
                'phone_no' => '0558153496',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 300,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'MARY',
                'idorpassport' => 'PP000035',
                'whatsapp_no' => '0545989838',
                'phone_no' => '0545989838',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'OMI',
                'idorpassport' => 'PP000036',
                'whatsapp_no' => '0562575323',
                'phone_no' => '0562575323',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 100,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'JOHN',
                'idorpassport' => 'PP000037',
                'whatsapp_no' => '0527734213',
                'phone_no' => '0527734213',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'LASLIE',
                'idorpassport' => 'PP000038',
                'whatsapp_no' => '0557204486',
                'phone_no' => '0557204486',
                'gender' => 'Female',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
            [
                'name' => 'ASAD',
                'idorpassport' => 'PP000039',
                'whatsapp_no' => '0520000000',
                'phone_no' => '0520000000',
                'gender' => 'Male',
                'country_id' => 175,
                'status' => 0,
                'fixed_deposit' => 0,
                'previous_balance' => 0,
                'joined_date' => 2021-12-01,
                'created_at' => 2021-12-01,
                'updated_at' => 2021-12-01,
            ],
        ];

        foreach ($tenants as $key => $value) {
            Tenant::create($value);
        }
    }
}