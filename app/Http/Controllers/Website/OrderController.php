<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('website.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('website.checkout.create', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('website.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Validate user info
        $validated = $request->validate([
            'full_name'        => 'required|string|max:255',
            'phone_number'     => 'required|string|max:20',
            'delivery_address' => 'required|string|max:500',
        ]);

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create order
        $order = Order::create([
            'full_name'        => $validated['full_name'],
            'phone_number'     => $validated['phone_number'],
            'delivery_address' => $validated['delivery_address'],
            'total_price'      => $total,
            'status'           => 'processing',
            'user_id'          => auth()->check() ? auth()->id() : null,
        ]);

        // Attach items
        foreach ($cart as $id => $item) {
            // Stock validation
            $product = Product::find($id);
            if (!$product || $product->stock < $item['quantity']) {
                return redirect()->route('website.cart.index')
                    ->with('error', 'Not enough stock for ' . $item['name']);
            }

            // Deduct stock
            $product->stock = $product->stock - $item['quantity'];
            $product->save();

            // Save order items
            $order->items()->create([
                'product_id' => $id,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('website.orders.show', $order->id)
            ->with('success', 'Your order has been placed successfully.');
    }

    public function show(Order $order)
    {
        $order->load('items.product');

        return view('website.orders.show', compact('order'));
    }
}
