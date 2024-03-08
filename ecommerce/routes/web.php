<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Import AuthController
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\OrderController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth', 'role'])->group(function () {
    // Route::resource('products', ProductController::class);
    // Route for showing the form to add a new product
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::resource('orders', OrderController::class);
    // Route for storing the newly created product
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Route for listing all products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashbaord.index');

    // Route::get('/dashboard', function () {
    //     return view('admin.dashboard');
    // });
    
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::resource('products', ProductController::class)->except(['update']);
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/products/{productId}/orders', [OrderController::class, 'getOrdersForProduct'])->name('products.orders');
    Route::post('/products/deleteSelected', [ProductController::class, 'deleteSelected'])->name('products.deleteSelected');

});

// Auth routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.submit');
