<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShoppingMallOrdersController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\StockController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/stock/dai3', [ShoppingMallOrdersController::class, 'index'])->name('stock.dai3.index')->middleware('auth');
Route::get('/stock/dai3/search', [ShoppingMallOrdersController::class, 'search'])->name('stock.dai3.search');
Route::post('/stock/dai3/supplier', [ShoppingMallOrdersController::class, 'supplier'])->name('stock.dai3.supplier');
Route::post('/stock/dai3/confirm', [ShoppingMallOrdersController::class, 'confirm'])->name('stock.dai3.confirm');
Route::post('/stock/dai3/send', [ShoppingMallOrdersController::class, 'send'])->name('stock.dai3.send');
Route::get('/stock/admin', [StockController::class, 'admin'])->name('stock.admin');
Route::post('/stock/form', [StockController::class, 'form'])->name('stock.form');

// SAML認証関係
Route::get('/login', [AuthController::class, 'login'])->name('login');
//Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index')->middleware('auth');
Route::get('/auth/redirect', function () {
    return Socialite::driver('saml2')->redirect();
})->name('auth.redirect');
Route::get('/auth/saml2/metadata', function () {
    return Socialite::driver('saml2')->getServiceProviderMetadata();
});
Route::get('/auth/callback', [AuthController::class, 'callback'])->name('auth.callback');
