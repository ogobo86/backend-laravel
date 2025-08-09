<?php

namespace App\Http\Controllers;

use App\Business\Entities\ConceptEntity;
use App\Business\Entities\SaleEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Models\Concept;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SaleController extends Controller
{
    public function get(){
        return response()->json(Sale::all(), Response::HTTP_OK);
    }

    public function create(SaleRequest $request){

        $conceptEntity=[];

        foreach($request->concepts as $concept){
            $conceptEntity[]=new ConceptEntity($concept['quantity'], Product::find($concept['product_id'])->price,
                $concept['product_id']);
        }
        $saleEntity = new SaleEntity(null, $request->email, $request->sale_date, $conceptEntity);

        $sale = Sale::create([
            'email' => $saleEntity->email,
            'sale_date' => $saleEntity->sale_date,
            'total'=>$saleEntity->total
        ]);

        $sale->save();

        foreach ($conceptsEntity as $conceptEntity){
            $concept = Concept::create([
                'quantity'=>$conceptEntity->quiantity,
                'price'=>$conceptEntity->price,
                'product_id'=>$conceptEntity->product_id,
                'sale_id'=>$sale->id,
            ]);
            $concept->save();
        }

        return response()->json($saleEntity, Response::HTTP_CREATED);
    }


}
