<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\UserCartItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $latestOrders = Order::latest()->take(5)
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.created_at', 'orders.product_id', 'products.name as product_name', 'users.name as user_name')
            ->get();

        $latestHits = [88, 68, 79, 57, 50, 55, 70]; 
        $popularHits = [33, 45, 37, 21, 55, 74, 69]; 
        $featuredHits = [44, 19, 38, 46, 85, 66, 79]; 

        // Fetch latest products for each month
        // $latestHits = $this->getLatestProductsCountByMonth();

        // // Fetch popular products for each month based on the number of orders
        // $popularHits = $this->getPopularProductsCountByMonth();

        // // Fetch featured products for each month based on custom criteria
        // $featuredHits = $this->getFeaturedProductsCountByMonth();


        // // Fetch featured products based on user likes
        // $featuredProducts = Product::join('user_product_likes', 'products.id', '=', 'user_product_likes.product_id')
        //     ->orderBy('user_product_likes.created_at', 'desc')
        //     ->take(7)
        //     ->get();

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
    private function getLatestProductsCountByMonth()
    {
        $latestHits = [];
        for ($i = 1; $i <= 12; $i++) {
            $latestHits[$i] = Order::join('products', 'orders.product_id', '=', 'products.id')
                ->whereMonth('orders.created_at', $i)
                ->count();
        }
        return $latestHits;
    }

    // Method to get count of popular products for each month based on the number of orders
    private function getPopularProductsCountByMonth()
    {
        $popularHits = [];
        for ($i = 1; $i <= 12; $i++) {
            $popularHits[$i] = Product::join('orders', 'products.id', '=', 'orders.product_id')
                ->whereMonth('orders.created_at', $i)
                ->selectRaw('COUNT(orders.id) as order_count')
                ->orderByDesc('order_count')
                ->value('order_count') ?? 0;
        }
        return $popularHits;
    }

    // Method to get count of featured products for each month based on custom criteria
    private function getFeaturedProductsCountByMonth()
    {
        $featuredHits = [];
        for ($i = 1; $i <= 12; $i++) {
            // Example custom criteria: Featured products are those added within the last 30 days
            $featuredHits[$i] = Product::whereDate('created_at', '>=', Carbon::now()->subDays(30))
                ->whereMonth('created_at', $i)
                ->count();
        }
        return $featuredHits;
    }
}
