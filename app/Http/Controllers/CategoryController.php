<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function productIndex(Category $category)
    {
        return Inertia::render("ProductIndex", [
            "products" => Product::withCount('sales')->whereCategoryId($category->id)->orderByDesc('sales_count')->paginate(),
        ]);
    }
}
