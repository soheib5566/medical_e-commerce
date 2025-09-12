<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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

    public function updateProduct(Product $product)
    {
        $data = $this->validated();

        if ($this->hasFile('image')) {
            $data['image'] = $this->file('image')->store('products', 'public');
        }

        $product->update($data);

        return $product->refresh();
    }

    public function messages()
    {
        return [
            'name.required'      => 'The product name is required.',
            'price.required'     => 'The product price is required.',
            'stock.required'     => 'The product stock is required.',
            'category_id.exists' => 'The selected category does not exist.',
        ];
    }
}
