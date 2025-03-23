<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerController extends Controller
{
     // List all products of the logged-in farmer
     public function index() {
        return Product::where('user_id', Auth::id())->get();

    }

    // Add a new product
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $path = $request->file('image')->store('products', 'public');

        return Product::create([
            'user_id' => Auth::id(),
            // 'farmer_id' => rand(1,6),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $path
        ]);
    }

    // Update a product
    public function update(Request $request, $id) {
        $product = Product::where('farmer_id', Auth::id())->findOrFail($id);

        $product->update($request->only(['name', 'price', 'stock']));

        return response()->json(['message' => 'Product updated successfully']);
    }

    // Delete a product
    public function destroy($id) {
        $product = Product::where('farmer_id', Auth::id())->findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    // List all orders for the farmer's products
    public function orders() {
        return Order::whereHas('product', function ($query) {
            $query->where('farmer_id', Auth::id());
        })->get();
    }

    // Update order status
    public function updateOrderStatus(Request $request, $id) {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);
        return response()->json(['message' => 'Order status updated']);
    }

    // Farmer earnings
    public function earnings() {
        $totalSales = Order::whereHas('product', function ($query) {
            $query->where('farmer_id', Auth::id());
        })->sum('total_price');

        return response()->json(['total_sales' => $totalSales]);
    }
}
