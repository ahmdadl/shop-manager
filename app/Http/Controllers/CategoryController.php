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
        $req = (object) request()->validate([
            "sellPrice" => "array",
            "sellPrice.from" => "nullable|numeric",
            "sellPrice.to" => "nullable|numeric",
            "buyPrice" => "array",
            "buyPrice.from" => "nullable|numeric",
            "buyPrice.to" => "nullable|numeric",
            "amount" => "array",
            "amount.from" => "nullable|integer",
            "amount.to" => "nullable|integer",
            "soldAmount" => "array",
            "soldAmount.from" => "nullable|integer",
            "soldAmount.to" => "nullable|integer",
        ]);

        $products = Product::withCount("sales")->whereCategoryId($category->id);

        if (isset($req->sellPrice)) {
            // sellPrice range
            if ($req->sellPrice["from"] || $req->sellPrice["to"]) {
                $products->whereBetween("sell_price", [
                    (float) $req->sellPrice["from"],
                    (float) $req->sellPrice["to"],
                ]);
            }

            // buyPrice range
            if ($req->buyPrice["from"] || $req->buyPrice["to"]) {
                $products->whereBetween("buy_price", [
                    (float) $req->buyPrice["from"],
                    (float) $req->buyPrice["to"],
                ]);
            }

            // amount range
            if ($req->amount["from"] || $req->amount["to"]) {
                $products->whereBetween("amount", [
                    (int) $req->amount["from"],
                    (int) $req->amount["to"],
                ]);
            }

            // sold amount range
            if ($req->soldAmount["from"] || $req->soldAmount["to"]) {
                $products->whereRaw('(select count(*) from "sales" where "products"."id" = "sales"."product_id") between ? and ?', [
                    (int) $req->soldAmount["from"],
                    (int) $req->soldAmount["to"],
                ]);
            }
        }

        // dd($products->toSql(), $products->getBindings());

        return Inertia::render("ProductIndex", [
            "products" => $products->orderByDesc("sales_count")->paginate(),
            "category_slug" => $category->slug,
        ]);
    }
}
