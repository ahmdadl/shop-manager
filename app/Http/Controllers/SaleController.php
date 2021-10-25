<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{

    public function index() {
        return Inertia::render('Report', [
            'salesData' => Sale::with('product')->paginate(),
            'categories' => fn() => Category::all(),
        ]);
    }

    public function sell(Product $product)
    {
        $req = request()->validate([
            "amount" => [
                "required",
                "integer",
                "min:1",
                request()->get("type") === "sell"
                    ? "max:{$product->amount}"
                    : "",
            ],
            "type" => "required|alpha|max:4",
        ]);

        $done = Sale::create([
            "product_id" => $product->id,
            "amount" => $req["amount"],
            "type" => $req["type"],
            "total" => ((int) $req["amount"]) * $product->price,
        ])->id;

        if ($done) {
            // update product amount
            $product->amount =
                $req["type"] === "sell"
                    ? $product->amount - $req["amount"]
                    : $product->amount + $req["amount"];
            $product->update();
        }

        return response()->json([
            "done" => $done,
        ]);
    }

    public function buy()
    {
    }

    public function destroy(Sale $sale) {
        return response()->json([
            'done' => $sale->delete(),
        ]);
    }
}
