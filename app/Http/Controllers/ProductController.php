<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Category $category)
    {
        $category->loadMissing("products");
        $products = $category->products;
        // $output = [];

        // foreach ($products as $product) {
        //     $output[] = (object) [
        //         "label" => $product->title,
        //         "value" => $product->slug,
        //         "img" => $product->img,
        //     ];
        // }

        return response()->json($products);
    }

    public function store() {
        $req = (object) request()->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'price' => 'required|min:1',
        ]);

        $p = Product::create([
            'category_id' => $req->category_id,
            'title' => $req->title,
            'amount' => $req->amount,
            'price' => $req->price,
        ]);

        return response()->json($p);
    }
}
