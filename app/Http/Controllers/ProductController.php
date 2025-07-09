<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
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

    public function store(Request $request){
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|max:2000',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:category,id'
            ]);

            $product = Product::create($validatedData);

            return response()->json($product);
        }catch(ValidationException $e){
            return response()->json(["error"=> $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}