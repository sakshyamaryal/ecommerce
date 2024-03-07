<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Import AuthController
use App\Http\Controllers\ProductController; 
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
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('/user-profile', function () {
    return view('user-profile');
})->name('user-profile');

Route::get('/user-management', function () {
    return view('user-management');
})->name('user-management');

// Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::middleware(['auth', 'role'])->group(function () {
    // Route::resource('products', ProductController::class);
    // Route for showing the form to add a new product
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    // Route for storing the newly created product
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Route for listing all products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');


    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

});

// Auth routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.submit');
