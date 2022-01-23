<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $users = [
            [
            'name' => 'Minn Khant Naing',
            'username' => 'mrminnkhantnaing',
            'phone_no' => '+971 58531 4572',
            'email' => 'mr.minnkhantnaing@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'address' => 'Yangon, Myanmar',
            'profile_picture' => 'images/profile_pictures/mrminnkhantnaing.jpeg',
            'remember_token' => Str::random(10),
            ],
            [
            'name' => 'Khin Zin Zin Thinn',
            'username' => 'khinnzinzinthinn',
            'phone_no' => '+971 58531 4573',
            'email' => 'khinzinzinthinn@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'address' => 'Yangon, Myanmar',
            'profile_picture' => 'images/profile_pictures/mrminnkhantnaing.jpeg',
            'remember_token' => Str::random(10),
            ],
            [
            'name' => 'Barack Obama',
            'username' => 'barackobama',
            'phone_no' => '+1 23456 7890',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'address' => 'California, USA',
            'profile_picture' => 'images/default/default-profile.png',
            'remember_token' => Str::random(10),
            ],
            [
            'name' => 'Aamir Khan',
            'username' => 'aamirkhan',
            'phone_no' => '+91 23456 7890',
            'email' => 'manager@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'address' => 'New Delhi, India',
            'profile_picture' => 'images/default/default-profile.png',
            'remember_token' => Str::random(10),
            ],
            [
            'name' => 'Shakira',
            'username' => 'shakira',
            'phone_no' => '+57 12345 6789',
            'email' => 'supervisor@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'address' => 'Bogota, Colombia',
            'profile_picture' => 'images/default/default-profile.png',
            'remember_token' => Str::random(10),
            ]
        ];

        foreach ($users as $key => $value) {
            User::create($value);
        }
    }
}
