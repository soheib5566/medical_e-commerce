<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    public function storeProduct()
    {
        $data = $this->validated();

        $data['image'] = $this->hasFile('image')
            ? $this->file('image')->store('products', 'public')
            : null;

        $product = Product::create($data);

        return $product->refresh();
    }

    public function messages()
    {
        return [
            'name.required'        => 'The product name is required.',
            'price.required'       => 'The product price is required.',
            'price.numeric'        => 'The product price must be a number.',
            'stock.required'       => 'The product stock is required.',
            'stock.integer'        => 'The product stock must be an integer.',
            'image.image'          => 'The uploaded file must be an image.',
            'image.mimes'          => 'The product image must be a file of type: jpeg, png, jpg, gif, webp.',
            'category_id.exists'   => 'The selected category does not exist.',
        ];
    }
}
