<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('website.cart.index', compact('cart', 'total'));
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['count' => $count]);
    }

    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $newQuantity = $request->quantity;

            // Validate quantity
            if ($newQuantity <= 0) {
                unset($cart[$product->id]);
            } elseif ($newQuantity <= $product->stock) {
                $cart[$product->id]['quantity'] = $newQuantity;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity exceeds available stock'
                ]);
            }

            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ]);
    }

    public function destroy(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ]);
    }
}
