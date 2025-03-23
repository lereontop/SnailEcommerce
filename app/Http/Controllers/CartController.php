<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Get user's cart
    public function index() {
        return Cart::where('user_id', Auth::id())->with('product')->get();
    }

    // Add to cart
    public function add(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return response()->json(['message' => 'Product added to cart', 'cart' => $cartItem]);
    }

    // Update cart item quantity
    public function update(Request $request) {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($request->cart_id);
        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Cart updated']);
    }

    // Remove item from cart
    public function remove($id) {
        Cart::where('user_id', Auth::id())->findOrFail($id)->delete();
        return response()->json(['message' => 'Item removed from cart']);
    }
}
