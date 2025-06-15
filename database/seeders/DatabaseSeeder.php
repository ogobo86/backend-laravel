<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Ejecucion por factorie
        Category::factory(3)->create()-> each(function ($category){
            // Aqui se esta asignando el producto a la categoria por id 
            Product::factory(10) -> create ([ 'category_id' => $category -> id]); 
        });

        // User::factory(10)->create();
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            CategoryTableSeeder::class,
            ProductTableSeeder::class
        ]);
        */
    }
}
