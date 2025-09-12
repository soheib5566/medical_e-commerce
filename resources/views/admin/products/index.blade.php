<h1>Products</h1>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Category</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->category?->name ?? 'No Category' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No products found</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination --}}
{{ $products->links() }}