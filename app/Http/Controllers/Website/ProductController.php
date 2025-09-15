<?php

namespace App\Http\Controllers\Website;

use App\Filters\Website\ProductFilter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, ProductFilter $filters)
    {
        $products = Product::with('category')
            ->filters($filters)
            ->paginate(12)
            ->appends($request->query());

        return view('website.products.index', compact('products'));
    }

    public function store(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            if ($cart[$product->id]['quantity'] >= $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock limit reached'
                ]);
            }
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'stock' => $product->stock
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }
}
