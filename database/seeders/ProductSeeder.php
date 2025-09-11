<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(database_path('seeders/data/products.json')), true);

        foreach ($data as $group) {
            $categoryName = $group['category'];
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($group['products'] as $prod) {
                Product::create([
                    'name' => $prod['name'],
                    'price' => $prod['price'],
                    'image' => $prod['image'],
                    'category_id' => $category->id,
                    'description' => $prod['name'],
                    'stock' => 100,
                ]);
            }
        }
    }
}
