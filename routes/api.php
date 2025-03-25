<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreorderController;
use App\Http\Controllers\StockController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/preorder', [PreorderController::class, 'index'])->name('preorder.index');
Route::post('/preorder/items/{fileId}', [PreorderController::class, 'items'])->name('preorder.items');


Route::post('/stock/posts/{fileId}', [StockController::class, 'posts'])->name('stock.posts');
Route::post('/stock/items/{fileId}', [StockController::class, 'items'])->name('post.stock.items');
Route::post('/stock/notify/{fileId}', [StockController::class, 'notify'])->name('stock.notify');

Route::patch('/stock/items/{fileId}', [StockController::class, 'items'])->name('patch.stock.items');
