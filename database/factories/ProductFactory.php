<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "category_id" => fn() => Category::factory(),
            "title" => $this->faker->sentence(),
            "slug" => $this->faker->slug(),
            "amount" => random_int(0, 25),
            "price" => $this->faker->randomFloat(2, 5, 1000),
            "updated_at" => $this->faker->dateTimeBetween(
                "-3 months",
                "+3 months"
            ),
        ];
    }
}
