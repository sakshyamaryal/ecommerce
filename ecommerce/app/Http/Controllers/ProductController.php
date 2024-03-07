<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Method for showing the form to add a new product
    public function create()
    {
        return view('products.create');
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

        if ($request->hasFile('files')) {
            $i = 0;

            foreach ($request->file('files') as $file) {
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
        $product->save();

    
        return response()->json(['message' => 'Product created successfully'], 201); // Use HTTP status code 201 for successful creation
    }
    
    

    // Method for listing all products
    public function index()
    {
        $products = Product::all();
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
            'image' => $imagePathsString, // Storing multiple image paths as a comma-separated string
        ]);

        return response()->json(['message' => 'Product updated successfully'], 200);
    }


}
