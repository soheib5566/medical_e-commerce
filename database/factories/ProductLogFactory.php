<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductLog>
 */
class ProductLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'action' => $this->faker->randomElement(['created', 'updated', 'deleted']),
            'changed_by' => User::factory(),
            'changes' => json_encode([
                'price' => ['old' => 100, 'new' => 120]
            ]),
        ];
    }
}
