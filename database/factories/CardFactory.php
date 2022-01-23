<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Declare an associative array
        $status = array( "0" => "available", "1" => "active", "2" => "lost");

        // Use array_rand function to returns random key
        $key = array_rand($status);

        return [
            'code' => rand(10000000, 20000000),
            'status' => $status[$key],
        ];
    }
}
