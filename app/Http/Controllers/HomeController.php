<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Str;

class HomeController extends Controller
{
    protected $reqParams = [
        "title" => "required|string|max:255",
        "avatar" => "sometimes|image|max:2048",
    ];

    public function index()
    {
        return Inertia::render("Home", [
            "categories" => Category::withCount("products")
                ->latest()
                ->get(),
        ]);
    }

    public function store()
    {
        $req = request()->validate($this->reqParams);

        // save category
        $cat = Category::create([
            "title" => $req["title"],
            "img" => isset($req["avatar"])
                ? Str::replace(
                    "public/",
                    "",
                    $req["avatar"]?->store("public/categories")
                )
                : null,
        ]);

        return response()->json($cat);
    }

    public function update(Category $category)
    {
        $req = request()->validate($this->reqParams);

        $category->title = $req["title"];

        if (isset($req["avatar"])) {
            // delete old image then upload new one
            Storage::delete("public/" . $category->img);

            // upload new image
            $category->img = Str::replace(
                "public/",
                "",
                $req["avatar"]?->store("public/categories")
            );
        }

        return response()->json($category->update() ? $category : []);
    }

    public function destroy(Category $category)
    {
        // delete avatar
        Storage::delete("public/" . $category->img);

        return response()->json([
            "done" => $category->delete(),
        ]);
    }
}
