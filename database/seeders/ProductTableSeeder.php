<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        // Obtener los ID existentes de la tabla Category (FK)
        $categoryIds = DB::table('category')->pluck('id')->toArray();
        // Valida que existan categorias
        if (empty($categoryIds)){
            $this->command->warn("No hay categorias en la tabla category");
            return;
        }
        // Generar Productos de manera aleatoria
        $products = [];
        for ($i=1; $i<=50; $i++){
            $products[] =[
                'name' => $faker->word,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2,10,500),
                'category_id' => $faker->randomElement($categoryIds), // Esta linea asigna una categoria de forma aleatoria
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // Poblar la DB
        DB::table('product')->insert($products);
    }
}
