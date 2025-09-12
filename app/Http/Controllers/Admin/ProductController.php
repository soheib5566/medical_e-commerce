<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\ProductFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{

    public function index(ProductFilter $filter)
    {
        $products = Product::with('category')
            ->filters($filter)
            ->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductStoreRequest $request)
    {
        $product = $request->storeProduct();

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Product '{$product->name}' created successfully.");
    }

    public function show(Product $product)
    {
        $product->load('category');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $request->updateProduct($product);

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Product '{$product->name}' updated successfully.");
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
