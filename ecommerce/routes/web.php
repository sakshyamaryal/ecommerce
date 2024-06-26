<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Import AuthController
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ReportController;

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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');


Route::post('/addToFavorites', [ProductController::class, 'addToFavorites'])->name('addToFavorites');
Route::post('/makeOrder', [OrderController::class, 'makeOrder'])->name('makeOrder');
Route::post('/add-to-cart', [ProductController::class, 'addToCart'])->name('add-to-cart');




Route::middleware(['auth', 'admin'])->group(function () {
    // Route::resource('products', ProductController::class);
    // Route for showing the form to add a new product
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::resource('orders', OrderController::class);
    // Route for storing the newly created product
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Route for listing all products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/changerole', [UserController::class, 'changeRole'])->name('users.changeRole');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/products/{id}/details', [ProductController::class, 'details'])->name('product.details');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Route::get('/dashboard', function () {
    //     return view('admin.dashboard');
    // });

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::resource('products', ProductController::class)->except(['update']);
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/products/{productId}/orders', [OrderController::class, 'getOrdersForProduct'])->name('products.orders');
    Route::post('/products/deleteSelected', [ProductController::class, 'deleteSelected'])->name('products.deleteSelected');
    Route::post('/orders/{id}/accept', [OrderController::class, 'accept'])->name('orders.accept');
    Route::post('/orders/statusWiseOrder', [OrderController::class, 'statusWiseOrder'])->name('orders.statusWiseOrder');
    Route::get('/reports', [ReportController::class, 'generateReport'])->name('admin.report');

    Route::post('/reports/filter', [ReportController::class, 'filterReport'])->name('admin.report.filter');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Auth routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.submit');

Route::get('/productList', [ProductController::class, 'productList'])->name('productList');


Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
Route::get('/userpurchase', [ProductController::class, 'userpurchase'])->name('userpurchase');
Route::get('/wish', [ProductController::class, 'wish'])->name('wish');
Route::post('/update-cart', [ProductController::class, 'updateCart'])->name('cart.update');
Route::post('/delete-item', [ProductController::class, 'deleteItem'])->name('cart.delete');
Route::post('/checkoutitems', [OrderController::class, 'checkoutitems'])->name('orders.checkoutitems');
