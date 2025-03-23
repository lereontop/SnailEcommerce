<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
     // List all products
     public function index() {
        return response()->json(Product::all(), 200);
    }

    // Get a single product
    public function show($id) {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product, 200);
    }

    // Get products by category
    public function getByCategory($category) {
        $products = Product::where('category', $category)->get();
        return response()->json($products, 200);
    }
}
