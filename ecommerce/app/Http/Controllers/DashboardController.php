<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $latestOrders = Order::latest()->take(5)
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->select('orders.created_at','orders.product_id', 'products.name as product_name', 'users.name as user_name')
        ->get();

        // dd($latestOrders);

        $products = Product::all();
        return view('admin.dashboard', compact('products','latestOrders'));
    }

    
}
