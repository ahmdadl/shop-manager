<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
    public function index(bool $soldOnly = false, bool $buyOnly = false)
    {
        $req = (object) request()->validate([
            "date" => "sometimes|array|min:2|max:2",
            "categorySlug" => "nullable|string|exists:categories,slug",
            "productSlug" => "nullable|string|exists:products,slug",
            "price" => "array",
            "price.from" => "nullable|numeric",
            "price.to" => "nullable|numeric",
            "amount.from" => "nullable|integer",
            "amount.to" => "nullable|integer",
        ]);

        $sales = Sale::with("product");

        // sold only
        if ($soldOnly) {
            $sales->whereType("sell");
        } elseif ($buyOnly) {
            $sales->whereType("buy");
        }

        // if any filter was applied
        if (isset($req->date)) {
            // date range
            if (null !== $req->date["from"]) {
                $sales->whereBetween("updated_at", [
                    $req->date["from"],
                    $req->date["to"],
                ]);
            }

            //category
            if ($req->categorySlug && null === $req->productSlug) {
                $products = Category::whereSlug($req->categorySlug)->with(
                    "products"
                );
                $sales = $sales->whereIn("product_id", $products->pluck("id"));
            }

            // product
            if ($req->productSlug) {
                $sales->whereProductId(
                    Product::whereSlug($req->productSlug)->first("id")
                );
            }

            // price range
            if ($req->price["from"] || $req->price["to"]) {
                $sales->whereBetween("total", [
                    (int) $req->price["from"],
                    (int) $req->price["to"],
                ]);
            }

            // amount range
            if ($req->amount["from"] || $req->amount["to"]) {
                $sales->whereBetween("amount", [
                    (int) $req->amount["from"],
                    (int) $req->amount["to"],
                ]);
            }
        }

        // dd($sales->toSql());

        return Inertia::render("Report", [
            "salesData" => $sales->latest()->paginate(),
            "categories" => fn() => Category::all(),
        ]);
    }

    public function sold()
    {
        return $this->index(true);
    }

    public function bought()
    {
        return $this->index(false, true);
    }

    public function sell(Product $product)
    {
        $req = request()->validate([
            "type" => "required|alpha|max:4",
            "amount" => [
                "required",
                "integer",
                "min:1",
                request()->get("type") === "sell"
                    ? "max:{$product->amount}"
                    : "",
            ],
        ]);

        $price =
            $req["type"] === "sell"
                ? $product->sell_price
                : $product->buy_price;

        $done = Sale::create([
            "product_id" => $product->id,
            "amount" => $req["amount"],
            "type" => $req["type"],
            "total" => ((int) $req["amount"]) * $price,
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

    public function destroy(Sale $sale)
    {
        return response()->json([
            "done" => $sale->delete(),
        ]);
    }

    public function stats()
    {
        $buy = Sale::whereType("buy")->sum("total");

        $sell = Sale::whereType("sell")->sum("total");

        $diff = $sell - $buy;

        return response()->json(compact("buy", "sell", "diff"));
    }
}
