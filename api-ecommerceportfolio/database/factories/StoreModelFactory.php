<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'street_number' => '0',
            'street_name' => 'Street Name',
            'city' => 'Simple City D.C',
            'state' => 'Simple Country',
            'zip_code' => '31000',
            'latitude' => 1,
            'longitude' => 2,
            'contact_phone' => '+33 123456',
            'image_url' => '/store1.jpeg',
        ];
    }
}
