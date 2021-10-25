<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use DB;
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
        DB::beginTransaction();
        // \App\Models\User::factory(10)->create();
        $cats = Category::factory()->count(20)->create();
        $cats->each(function (Category $category) {
            $products = Product::factory(random_int(5, 15))->create([
                'category_id' => $category->id,
            ]);
            
            $products->each(function(Product $product) {
                Sale::factory(random_int(2, 5))->create([
                    'product_id' => $product->id,
                ]);
            });
        });

        DB::commit();
    }
}
