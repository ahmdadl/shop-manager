<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", [HomeController::class, "index"]);
Route::post("/categories", [HomeController::class, "store"]);
// axios not updating with patch request
Route::post("/categories/{category}", [HomeController::class, "update"]);
Route::delete("/categories/{category}", [HomeController::class, "destroy"]);

// product
Route::get("/categories/{category}", [ProductController::class, "index"]);
Route::post("/products", [ProductController::class, "store"]);
Route::patch("/products/{product}", [ProductController::class, "update"]);
Route::delete("/products/{product}", [ProductController::class, "destroy"]);

// sales
Route::get("/reports", [SaleController::class, "index"]);
Route::get("/reports/sold", [SaleController::class, "sold"]);
Route::get("/reports/bought", [SaleController::class, "bought"]);
Route::post("/products/{product}/sales", [SaleController::class, "sell"]);
Route::delete("/sales/{sale}", [SaleController::class, "destroy"]);

Route::get("/sales/stats", [SaleController::class, "stats"]);
Route::get("/products/stats", [ProductController::class, "stats"]);
// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');

Route::get("/settings", [SettingController::class, "index"]);
Route::get("/backup-download/{fileName}", [
    SettingController::class,
    "download",
]);
Route::post("/settings/backup-db", [SettingController::class, "backup"]);
Route::post("/settings/restore-db", [SettingController::class, "restore"]);

Route::get("/{category}", [CategoryController::class, "productIndex"]);
