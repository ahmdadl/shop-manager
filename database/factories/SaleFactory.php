<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => fn() => Product::factory(),
            'type' => Arr::random(['sell', 'buy']),
            'amount' => random_int(1, 50),
            'total' => random_int(50, 1000).random_int(0, 99),
        ];
    }
}
