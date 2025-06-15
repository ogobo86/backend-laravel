<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Se indica como va a trabajar
            'name' => $this -> faker -> word(),
            'description' => $this -> faker -> sentence,
            'category_id' => Category::factory(),
            'price' => $this -> faker -> randomFloat(2,10,500)
        ];
    }
}
