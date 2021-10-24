<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render("Home", [
            "categories" => Category::latest()->get(),
        ]);
    }

    public function store()
    {
        $req = request()->validate([
            "title" => "required|string|max:255",
            "avatar" => "sometimes|image|max:2048",
        ]);

        // save category
        $cat = Category::create([
            "title" => $req["title"],
            "img" => isset($req["avatar"])
                ? Str::replace('public/', '', $req["avatar"]?->store("public/categories"))
                : null,
        ]);

        return response()->json($cat);
    }
}
