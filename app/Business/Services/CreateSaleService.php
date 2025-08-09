<?php

namespace App\Business\Services;

use App\Business\Entities\ConceptEntity;
use App\Business\Entities\SaleEntity;
use App\Http\Requests\SaleRequest;
use App\Models\Concept;
use App\Models\Product;
use App\Models\Sale;

class CreateSaleService{

    public function create(SaleRequest $request){

        $conceptsEntity=[];

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

        $saleEntity->id = $sale->id;

        return $saleEntity;

    }

}