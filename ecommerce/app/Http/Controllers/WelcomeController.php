<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    //
    public function index()
    {
        $userId = Auth::id();
        $products = Product::leftJoin('user_product_likes', function ($join) use ($userId) {
            $join->on('products.id', '=', 'user_product_likes.product_id')
                 ->where('user_product_likes.user_id', '=', $userId);
        })
        ->select('products.*', 'user_product_likes.id AS like_id')
        ->get();

        $latestproducts = Product::leftJoin('user_product_likes', function ($join) use ($userId) {
            $join->on('products.id', '=', 'user_product_likes.product_id')
                 ->where('user_product_likes.user_id', '=', $userId);
        })
        ->select('products.*', 'user_product_likes.id AS like_id')
        ->orderBy('products.id', 'desc')
        ->get();
        
        return view('welcome', compact('products','latestproducts'));
    }
}
