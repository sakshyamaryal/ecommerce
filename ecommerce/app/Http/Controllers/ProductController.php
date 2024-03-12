<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Favorite;
use App\Models\UserCartItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Method for showing the form to add a new product
    public function create()
    {
        return view('products.create');
    }

    public function details($id, Request $request)
    {
        $product = Product::findOrFail($id);

        // Retrieve orders associated with the product along with user names
        $orders = Order::where('product_id', $id)
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name', 'users.email')
            ->when($request->has('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->latest()
            ->take(10)
            ->get();

        // Pass both product and orders to the view
        return view('admin.productOrderDetail', compact('product', 'orders'));
    }

    // Method for storing the newly created product
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'available_stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'images.*' => ['required', 'image', 'max:2048'], // Each image max file size 2MB (2048 KB)
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $imageNames = [];
        $img_exist = false;

        if ($request->hasFile('images')) {
            $i = 0;

            foreach ($request->file('images') as $file) {
                $timestamp = now()->timestamp;
                $itemName = strtolower(trim(str_replace(' ', '-', $request->itemname)));
                $imageName = "{$itemName}{$i}_{$timestamp}.{$file->extension()}";

                // Ensure the directory exists or create it
                $directory = 'images/product_images';

                // Move the file to the directory
                $file->move(public_path($directory), $imageName);

                // Store the filename in the array
                $imageNames[] = $imageName;
                $i++;
            }
            $img_exist = true;
        }


        // Convert imagePaths array to string
        $imagePathsString = implode(',', $imageNames);

        // Create product with image paths
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->available_stock = $request->input('available_stock');
        $product->is_active = $request->input('is_active');
        $product->image = $imagePathsString; // Storing multiple image paths as a comma-separated string
        $product->added_by = auth()->user()->id;

        $product->save();


        return response()->json(['message' => 'Product created successfully'], 201); // Use HTTP status code 201 for successful creation
    }



    // Method for listing all products
    public function index(Request $request)
    {
        $status = $request->input('status');
        if ($status === 'active') {
            $products = Product::where('is_active', true)->get();
        } elseif ($status === 'inactive') {
            $products = Product::where('is_active', false)->get();
        } else {
            $products = Product::all();
        }

        return view('products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }


    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'available_stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'images.*' => ['nullable', 'image', 'max:2048'], // Each image max file size 2MB (2048 KB)
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $product = Product::findOrFail($id);


        $imageNames = [];
        $img_exist = false;
        // dd($request->hasFile('files'),$request->hasFile('images'));
        // dd();
        if ($request->hasFile('images')) {

            $i = 0;

            foreach ($request->file('images') as $file) {
                $timestamp = now()->timestamp;
                $itemName = strtolower(trim(str_replace(' ', '-', $request->itemname)));
                $imageName = "{$itemName}{$i}_{$timestamp}.{$file->extension()}";

                // Ensure the directory exists or create it
                $directory = 'images/product_images';

                // Move the file to the directory
                $file->move(public_path($directory), $imageName);

                // Store the filename in the array
                $imageNames[] = $imageName;
                $i++;
            }

            $img_exist = true;
        }

        // Convert imagePaths array to string
        $imagePathsString = implode(',', $imageNames);
        // dd($imagePathsString);
        // Update product with new data and image paths
        $product->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'available_stock' => $request->input('available_stock'),
            'is_active' => $request->input('is_active'),
            'image' => $imagePathsString,

        ]);

        return response()->json(['message' => 'Product updated successfully'], 200);
    }

    public function deleteSelected(Request $request)
    {
        $productIds = $request->input('productIds');

        // Delete the selected products
        Product::whereIn('id', $productIds)->delete();

        return response()->json(['message' => 'Selected products deleted successfully']);
    }

    public function show($id)
    {
        $userId = Auth::id();
        $product = DB::table('products')
            ->join('users', 'users.id', '=', 'products.added_by')
            ->leftJoin('user_product_likes', function ($join) use ($userId) {
                $join->on('products.id', '=', 'user_product_likes.product_id')
                    ->where('user_product_likes.user_id', '=', $userId);
            })
            ->select(
                'users.id AS user_id',
                'users.name AS user_name',
                'users.email AS user_email',
                'products.id AS product_id',
                'products.name AS product_name',
                'products.description AS product_description',
                'products.price AS product_price',
                'products.available_stock AS product_available_stock',
                'products.is_active AS product_is_active',
                'products.created_at AS product_created_at',
                'products.updated_at AS product_updated_at',
                'products.image',
                'user_product_likes.id AS like_id'
            )
            ->where('products.id', $id)
            ->first();


        return view('user.productdetail', compact('product'));
    }

    public function addToFavorites(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'You must be logged in to continue'], 401);
        }

        $productId = $request->input('product_id');
        $user = $request->user();

        // Check if the product is already liked by the user
        $like = Favorite::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($like) {
            // Product already liked, so remove like
            $like->delete();
            return response()->json('unliked');
        } else {
            // Product not liked, so add like
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
            return response()->json('liked');
        }
    }

    public function addToCart(Request $request)
    {

        $productId = $request->productId;
        $quantity = $request->quantity;
        $userId = auth()->user()->id;


        $cartItem = new UserCartItem();
        $cartItem->user_id = $userId;
        $cartItem->product_id = $productId;
        $cartItem->quantity = $quantity;
        $cartItem->save();


        return response()->json(['message' => 'Product added to cart successfully']);
    }


    public function productList()
    {
        $userId = Auth::id();
        $products = Product::leftJoin('user_product_likes', function ($join) use ($userId) {
            $join->on('products.id', '=', 'user_product_likes.product_id')
                ->where('user_product_likes.user_id', '=', $userId);
        })
            ->select('products.*', 'user_product_likes.id AS like_id')
            ->get();

        return view('user.product', compact('products'));
    }

    public function cart()
    {

        $userId = auth()->id();


        $productsInCart = DB::table('user_cart_items')
            ->where('user_id', $userId)
            ->join('products', 'user_cart_items.product_id', '=', 'products.id')
            ->select('products.*', 'user_cart_items.quantity')
            ->get();

        return view('user.addToCart', ['productsInCart' => $productsInCart]);
    }


    public function wish()
    {
        $userId = Auth::id();

        $products = Product::select('products.*', 'user_product_likes.id AS like_id')
            ->Join('user_product_likes', function ($join) use ($userId) {
                $join->on('products.id', '=', 'user_product_likes.product_id')
                    ->where('user_product_likes.user_id', '=', $userId);
            })
            ->get();
        return view('user.wishlist', compact('products'));
    }



    public function updateCart(Request $request)
    {
        // Retrieve product ID and quantity from the request and trim them
        $productId = trim($request->input('product_id'));
        $quantity = trim($request->input('quantity'));
        $userId = auth()->user()->id;

        // // Dump and die to inspect the received data
        // dd($productId, $quantity);

        // Find the cart item for the user and product
        $cartItem = UserCartItem::where('user_id', $userId)
            ->where('product_id', $productId);
        // ->first();

        // If the cart item exists, delete it
        if ($cartItem) {
            $cartItem->delete();
        }

        // Create a new cart item with the updated quantity
        $newCartItem = new UserCartItem();
        $newCartItem->user_id = $userId;
        $newCartItem->product_id = $productId;
        $newCartItem->quantity = $quantity;
        $newCartItem->save();

        // Return a success response
        return response()->json(['message' => 'Cart updated successfully']);
    }


    public function deleteItem(Request $request)
    {
        // Retrieve product ID from the request
        $productId = $request->input('product_id');
        $userId = auth()->id(); // Assuming you're using Laravel's built-in authentication

        // Find the cart item for the user and product
        $cartItem = UserCartItem::where('user_id', $userId)
            ->where('product_id', $productId);
        // ->first();

        // If the cart item exists, delete it
        if ($cartItem) {
            $cartItem->delete();
        }

        // Return a success response
        return response()->json(['message' => 'Item deleted from cart']);
    }
}
