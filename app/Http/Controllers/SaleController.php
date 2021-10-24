<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function sell(Product $product)
    {
        $req = request()->validate([
            "amount" => [
                "required",
                "integer",
                "min:1",
                "max:{$product->amount}",
            ],
        ]);

        $done = Sale::create([
            "product_id" => $product->id,
            "amount" => $req["amount"],
            'type' => 'sell',
        ])->id;

        if ($done) {
            // update product amount
            $product->amount -= $req["amount"];
            $product->update();
        }

        return response()->json([
            "done" => $done,
        ]);
    }
}
