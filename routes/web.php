<?php

use App\Http\Controllers\Frontend\CartItemController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

#Route::get('/', function () {
    #return view('welcome');
#});

Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');

Route::get('/products/{name}', [FrontEndController::class, 'viewProduct'])->name('frontend.product');

Route::get('/category/{name}', [FrontEndController::class, 'viewCategory'])->name('frontend.category');

Route::get('/cart', [CartItemController::class, 'viewCart'])->name('frontend.cart');


Route::post('/add-cart-item', [CartItemController::class, 'addCartItem'])->name('cart-item.store');

Route::post('/update-cart-item', [CartItemController::class, 'updateCartItem'])->name('cart-item.update');

Route::post('/remove-cart-item', [CartItemController::class, 'removeCartItem'])->name('cart-item.remove');


Route::get('/order-checkout', [OrderController::class, 'orderCheckout'])->name('order.checkout');

Route::post('/finalize-order', [OrderController::class, 'finalizeOrder'])->name('order.store');

Route::get('/orders', [FrontendController::class, 'viewOrders'])->name('frontend.orders');

Auth::routes();

