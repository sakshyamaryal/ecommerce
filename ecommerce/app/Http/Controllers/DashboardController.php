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
    public function generateReport(Request $request)
    {
        $type = $request->input('type', 'daily'); // Default to daily report if no type specified
    
        // Implement logic to generate reports based on $type
        switch ($type) {
            case 'daily':
                $reportData = $this->getDailyReport();
                break;
            case 'weekly':
                $reportData = $this->getWeeklyReport();
                break;
            case 'yearly':
                $reportData = $this->getYearlyReport();
                break;
            default:
                abort(404); // Handle invalid report types
        }
    
        // Calculate total revenue
        $totalRevenue = $reportData->sum('total_price');
    
        // Pass report data and total revenue to the same view for all report types
        return view('admin.report', compact('reportData', 'totalRevenue'));
    }
    
    private function getDailyReport()
    {
        return DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('COUNT(*) as total_quantity_sold'), DB::raw('SUM(products.price * 1) as total_price'))
            ->whereDate('orders.created_at', today())
            ->where('orders.status', 'completed')
            ->groupBy('products.name')
            ->get();
    }
    
    private function getWeeklyReport()
    {
        return DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('COUNT(*) as total_quantity_sold'), DB::raw('SUM(products.price * 1) as total_price'))
            ->whereBetween('orders.created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('orders.status', 'completed')
            ->groupBy('products.name')
            ->get();
    }
    
    private function getYearlyReport()
    {
        return DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('COUNT(*) as total_quantity_sold'), DB::raw('SUM(products.price * 1) as total_price'))
            ->whereYear('orders.created_at', now()->year)
            ->where('orders.status', 'completed')
            ->groupBy('products.name')
            ->get();
    }
    
}
