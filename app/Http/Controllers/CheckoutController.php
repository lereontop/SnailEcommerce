<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Process checkout
    public function process(Request $request) {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $totalPrice = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'unpaid'
        ]);

        Cart::where('user_id', Auth::id())->delete();

        return response()->json(['message' => 'Order placed', 'order_id' => $order->id]);
    }

    // Simulated Payment Integration
    public function payment(Request $request) {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:paystack,flutterwave,stripe'
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->update(['payment_status' => 'paid', 'status' => 'processing']);

        return response()->json(['message' => 'Payment successful']);
    }
}
