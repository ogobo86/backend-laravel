<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    // INDEX  GET
    //public function index(){
    //    return response()->json(Product::all());
    //}

    // PAGINADO  GET
    public function index(Request $request){
        $perPage = $request->query("per_page",10); // limita los registros a presentar.
        $page = $request->query("page", 0); // 
        $offset = $page * $perPage; // envia registros

        $products = Product::skip($offset)->take($perPage)->get();

        return response()->json($products);
    }

    // POST
    public function store(Request $request){
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|max:2000',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:category,id'
            ], [
                "name.required" => 'El nombre del producto es obligatorio.',
                "name.string" => 'El nombre debe ser una cadea de texto.',
                'name.max' => 'El nombre no puede superar los 255 caracteres.',
                'description.requiered' => 'La descripcion es obligatoria',
                'descroption.max' => 'La descripcion no puede superar los 2000 caracteres.',
                'price.required' => 'El precio es obligatorio.',
                'price.numeric' => 'El precio debe ser un numero.',
                'category_id.required' => 'La categoria es obligatoria.',
                'category_id.exists' => 'La categoria seleccionada no es valida'
            ]);

            $product = Product::create($validatedData);

            return response()->json($product);
        }catch(ValidationException $e){
            return response()->json(["error"=> $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    // UPDATE
    public function update(UpdateProductRequest $request, Product $product){
        
        try{
            $validatedData = $request -> validated();
            $product -> update($validatedData );

            return response()->json(["message" => "Producto actualizado correctamente", "product"=> $product]);
        }catch(Exception $e){
            return response()->json(["error"=> $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // DELETE
    public function destroy (Product $product){
        $product -> delete();
        return response() -> json(["message" => "Producto Eliminado."]);
    }

}