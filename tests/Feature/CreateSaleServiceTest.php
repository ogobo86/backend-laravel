<?php

use App\Business\Services\CreateSaleService;
use App\Http\Requests\SaleRequest;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

beforeEach(function(){
    $this->service = new CreateSaleService();
});

uses(RefreshDatabase::class); // Recrea la base de datos en cada test

test('Creacion de venta correctamente', function () {
    
    $product1 = Product::factory()->create(['price'=>100.0]);
    $product2 = Product::factory()->create(['price'=>50.0]);

    $request = new SaleRequest([
        'email' => 'algo@ejemplo.com',
        'sale_date'=> '2025-03-12 01:07:09',
        'concepts'=>[
            ['quantity'=>2, 'producr_id'=>$product1->id], //2 * 100 = 200
            ['quantity'=>3, 'producr_id'=>$product2->id], //3 * 50 = 150
        ]
    ]);

    $saleEntity = $this->service->create($request);

    // Validacion de la info en la BD
    $this->assertDatabaseHas('sale', [
        'id'=>$saleEntity->id,
        'email' => 'algo@ejemplo.com',
        'sale_date'=> '2025-03-12 01:07:09',
        'total'=>350.0
    ]);

    $this->assertDatabaseHas('concept', [
        'sale_id'=>$saleEntity->id,
        'product_id' => $product1->id,
        'quantity'=> 2,
        'price'=>100.0
    ]);

    $this->assertDatabaseHas('concept', [
        'sale_id'=>$saleEntity->id,
        'product_id' => $product2->id,
        'quantity'=> 3,
        'price'=>50.0
    ]);
});

test ('Falla la validacion del request', function(){
    $data = [
        'email' => '',
        'sale_data' => '',
        'concepts' => [],
    ];
    
    $validator = Validator::make($data(new SaleRequest())->rules());
    expect($validator->fails())->toBeTrue();
});