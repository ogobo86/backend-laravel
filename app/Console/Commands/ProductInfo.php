<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ProductInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:product-info {id : Id del producto a consultar} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta la iinformacion de un producto en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $id = $this->argument("id");

        // Busqueda en la DB 
        $product = Product::find($id);

        // Validacion de tipo de dato
        if (!is_numeric($id) || $id <=0){
            $this->error("Error: El ID debe ser un numero positivo");
            return Command::FAILURE;
        }
        // Manejo de error
        if(!$product){
            $this->error("El producto no existe");
            return Command::FAILURE;
        }

        // Mostrar
        $this->info("Producto Encontrado");
        $this->info("Nombre: {$product->name}");
        $this->info("Descripcion: {$product->description}");
        $this->info("Precio: {$product->price}");
    }
}
