<?php

namespace Database\Factories;

use App\Models\ProductModel;
use App\Models\StoreModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductModelFactory extends Factory
{
    protected $model = ProductModel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 300),
            'inventory_status' => $this->faker->randomElement([
                'INSTOCK',
                'LOWSTOCK',
                'OUTOFSTOCK',
            ]),
            'category' => $this->faker->randomElement([
                'Accessories',
                'Fitness',
                'Electronics',
                'Clothing',
            ]),
            'image_url' => $this->faker->imageUrl(),
            'currency' => $this->faker->randomElement([
                '€',
                '$',
                '£',
            ]),
            'store_id' => null,
        ];
    }

    public function inStock()
    {
        return $this->state(fn () => [
            'inventory_status' => 'INSTOCK',
        ]);
    }

    public function outOfStock()
    {
        return $this->state(fn () => [
            'inventory_status' => 'OUTOFSTOCK',
        ]);
    }

    public function accessories()
    {
        return $this->state(fn () => [
            'category' => 'Accessories',
        ]);
    }

    public function forStore($storeId)
    {
        return $this->state([
            'store_id' => $storeId,
        ]);
    }
}
