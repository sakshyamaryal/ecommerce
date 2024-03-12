<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $status = $request->input('status'); // Get the status filter from the request

        // Filter orders based on status
        $orders = Order::where('status', 'created')->latest()->get();
    
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getOrdersForProduct($productId)
    {
        // Fetch orders for the specified product
        $orders = Order::where('product_id', $productId)->get();

        // Return orders data as JSON response
        return response()->json($orders);
    }

    public function accept($id) {
        // Find the order
        $order = Order::findOrFail($id);
        
        // Update order status to completed
        $order->status = 'completed';
        $order->save();
        
        // Find the product associated with the order
        $product = Product::findOrFail($order->product_id);
        
        // Update the product
        if ($product->available_stock > 0) {
            // Decrease available stock by 1
            $product->available_stock -= 1;
            $product->save();
        }
        
        // Check if available stock is 0 and update product status accordingly
        if ($product->available_stock == 0) {
            $product->is_activ = 0;
            $product->save();
        }
        
        // Redirect back or to any other appropriate page
        return redirect()->back()->with('success', 'Order accepted successfully');
    }
    

    public function statusWiseOrder(Request $request)
    {
        // dd($request);
        $status = $request->input('status');
        $productId = $request->input('productId');
        // dd($request);
        $ordersQuery = Order::query();

        // if ($status) {
        //     $ordersQuery->where('status', $status);
        // }
        
        $orders = $ordersQuery->where('product_id', $productId)
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->select('orders.*', 'users.name as user_name', 'users.email')
        ->when($request->has('status'), function ($query) use ($request) {
            return $query->where('status', $request->status);
        })
        ->latest()
        ->take(10)
        ->get();
        // dd($orders);
        // Render the HTML for the list of orders
        $html = view('orders.order_list', compact('orders'))->render();

        // Return the HTML in the response
        return response()->json(['html' => $html]);
    }

    public function makeOrder(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = auth()->user()->id; // Assuming the user is authenticated

        // Create the order in the database
        Order::create([
            'product_id' => $productId,
            'user_id' => $userId,
            'status' => 'created'
        ]);

        return response()->json('Order placed successfully');
    }

    public function checkoutitems(Request $request)
    {
        // Retrieve product IDs from the request
        $productIds = $request->input('product_ids', []);

        foreach ($productIds as $productId) {
            $order = new Order();
            $order->user_id = auth()->id();
            $order->product_id = $productId;
            $order->status = 'created';
            $order->save();
        }

        // Return a success response
        return response()->json(['message' => 'Order placed successfully']);
    }

}
