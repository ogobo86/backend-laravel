<?php

namespace App\Http\Controllers;

use App\Business\Interfaces\MessageServiceInterface;
use App\Business\Services\HiService;
use App\Business\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InfoController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
        
    }
    
    // 
    public function message(MessageServiceInterface $hiService){

        return response()->json($hiService->hi());
    }

    public function iva(int $id){

        $product = Product::find($id);

        // Validacion
        if (!$product){
            return response()-> json(['message' => 'Producto no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $priceWithIVA = $this->productService->calculateIVA($product->price);
        return response()->json(['price' => $product->price, "priceWithIVA"=>$priceWithIVA]);
    }

}
