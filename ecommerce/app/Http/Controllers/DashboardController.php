<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\UserCartItem;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $latestOrders = Order::latest()->take(5)
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.created_at', 'orders.product_id', 'products.name as product_name', 'users.name as user_name')
            ->get();

        $latestHits = [88, 68, 79, 57, 50, 55, 70]; // Example data
        $popularHits = [33, 45, 37, 21, 55, 74, 69]; // Example data
        $featuredHits = [44, 19, 38, 46, 85, 66, 79]; // Example data
            $productSales = Product::join('orders', 'products.id', '=', 'orders.product_id')
            ->selectRaw('products.name, COUNT(orders.product_id) AS total_orders')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_orders')
            ->limit(10)
            ->get();

        $userActivities = User::join('orders', 'users.id', '=', 'orders.user_id')
            ->selectRaw('users.name, orders.status, COUNT(*) AS activity_count')
            ->groupBy('users.id', 'users.name', 'orders.status') 
            ->get();

            $cartItems = UserCartItem::join('products', 'user_cart_items.product_id', '=', 'products.id')
            ->selectRaw('products.name, COUNT(user_cart_items.product_id) AS cart_count')
            ->groupBy('products.id', 'products.name')
            ->get();
        

        $products = Product::all();
        
        return view('admin.dashboard', compact('products', 'latestOrders', 'latestHits', 'popularHits', 'featuredHits', 'productSales', 'userActivities', 'cartItems'));
    }
}
