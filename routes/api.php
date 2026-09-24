<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{AdminController,OrderController,ProductController};
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::post('/admin/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
 Route::post('/logout', [AuthController::class, 'logout']);
 Route::post('/products', [ProductController::class, 'store']); Route::put('/products/{product}', [ProductController::class, 'update']); Route::delete('/products/{product}', [ProductController::class, 'destroy']);
 Route::get('/orders', [OrderController::class, 'index']); Route::get('/orders/{order}', [OrderController::class, 'show']); Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);
 Route::get('/statistics', [AdminController::class, 'statistics']); Route::get('/customers', [AdminController::class, 'customers']); Route::get('/activities', [AdminController::class, 'activities']);
});
