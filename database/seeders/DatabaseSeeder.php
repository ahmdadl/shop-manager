<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
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
            Product::factory(random_int(5, 15))->create([
                'category_id' => $category->id,
            ]);
        });

        DB::commit();
    }
}
