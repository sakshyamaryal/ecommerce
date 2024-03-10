<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ReportController extends Controller
{
    //
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
        $checkInCount = $this->getCheckInCount();
        $orderCount = $this->getOrderCount();
        $lowStockProductCount = $this->getLowStockProductCount();
        $zeroStockProductCount = $this->getZeroStockProductCount();
        $totalOrdersCount = $this->getTotalOrdersCount();
        $totalOrdersValue = $this->getTotalOrdersValue();
        $averageOrderValue = $this->getAverageOrderValue();
        // Pass report data and total revenue to the same view for all report types
        return view('admin.report', compact('reportData', 'totalRevenue', 'checkInCount', 'orderCount', 'lowStockProductCount', 'zeroStockProductCount', 'totalOrdersCount', 'totalOrdersValue', 'averageOrderValue'));
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
 
    private function getCheckInCount()
    {
        return DB::table('users')->count();;
    }

    private function getOrderCount()
    {
        return DB::table('orders')->count();
    }

    private function getLowStockProductCount()
    {
        return DB::table('products')->where('available_stock', '<', 5)->count();
    }

    private function getZeroStockProductCount()
    {
        return DB::table('products')->where('available_stock', 0)->count();
    }

    private function getTotalOrdersCount()
    {
        return DB::table('orders')->count();
    }

    private function getTotalOrdersValue()
    {
        return DB::table('products')
                ->join('orders', 'products.id', '=', 'orders.product_id')
                ->selectRaw('SUM(products.price) * COUNT(orders.id) as total_orders_value')
                ->value('total_orders_value');
    }

    

    private function getAverageOrderValue()
    {
        $totalOrdersCount = $this->getTotalOrdersCount();
        if ($totalOrdersCount > 0) {
            $totalOrdersValue = $this->getTotalOrdersValue();
            return $totalOrdersValue / $totalOrdersCount;
        } else {
            return 0;
        }
    }
    public function filterReport(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
    
        // Retrieve report data between the provided start and end dates
        $reportData = DB::table('orders')
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->select('products.name', DB::raw('COUNT(*) as total_quantity_sold'), DB::raw('SUM(products.price * 1) as total_price'))
        ->whereDate(DB::raw('DATE(orders.created_at)'), '>=', $startDate)
        ->whereDate(DB::raw('DATE(orders.created_at)'), '<=', $endDate)
        ->where('orders.status', 'completed')
        ->groupBy('products.name')
        ->get();
        
        $totalRevenue = $reportData->sum('total_price');
    
        // Render the view to a string
        $html = view('admin.filtered_report', compact('reportData', 'totalRevenue'))->render();
    
        // Return the view HTML inside a JSON response
        return response()->json(['html' => $html]);
    }
    
    
}
