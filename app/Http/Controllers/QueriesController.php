<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB; 

class QueriesController extends Controller
{
    // USANDO ELOQUENT
    // Listar todos los resgistros 
    public function get(){
        $products = Product::all();
        return response() -> json($products);
    }

    // Obtener registro por ID
    public function getById(int $id){
        $product = Product::find($id);
        # Validacion
        if (!$product){
            return response()->json(["message" => "Producto no encontrado"], Response::HTTP_NOT_FOUND);
        };
        return response()->json($product);
    }

    // SELECT
    public function getNames(){
        $product = Product::select("name") -> get(); // Especificames que deseamos obtener
        return response() -> json($product);
    }
    
    // WHERE 
    public function searchName(string $name, float $price) {
        $products = Product::where("name", $name)
        -> where("price", ">", $price ) // Este segundo where simula un AND
        -> get();
        return response() -> json($products);
    }

    // LIKE
    public function searchString(string $value){
        $products = Product::where("description", "like", "%{$value}%")
        ->get();
        return response() -> json($products);
    }

    // OR
    //public function searchString(string $value){
    //    $products = Product::where("description", "like", "%{$value}%")
    //    ->orWHERE ("name", "like", "%{$value})
    //    ->get();
    //    return response() -> json($products);
    //}

    // Busqueda dinamica 
    public function advancedSearch (Request $request) {
        $products = Product::where(function($query) use($request){
            if ($request -> input("name")){
                $query -> where ("name", "like", "%{$request -> input ("name")}%");
            }
        })
        -> get();
        return response() -> json($products);
    }

    // JOIN
    public function join() {
        $products = Product::join ("category", "product.category_id", "=", "category.id")
            -> select ("product.*", "category.name as category")
            -> get();
        return response() -> json($products);
    }

    // GROUP BY 
    public function groupBy () {
        $result = Product::join ("category", "product.category_id", "=", "category.id")
            -> select("category.id", "category.name", DB::raw("COUNT(product.id) as Total" ))
            ->groupBy("category.id", "category.name")
            ->get();
        
        return response() -> json($result);
    }
}
