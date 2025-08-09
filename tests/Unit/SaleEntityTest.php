<?php

use App\Business\Entities\SaleEntity;
use App\Business\Entities\ConceptEntity;

test('Creacion de SaleEntity correctamente', function () {
    $concept1 = new ConceptEntity(quantity:2, price:50.0, product_id:1);
    $concept2 = new ConceptEntity(quantity:1, price:30.0, product_id:2);

    $sale = new SaleEntity(id:1, email:"test@algo.com", sale_date:'2025-01-12 15:02:02',
    concepts:[$concept1, $concept2]);

    expect($sale->id)->toBe(1)
        ->and($sale->email)->toBe("test@algo.com")
        ->and($sale->sale_date)->toBe('2025-01-12 15:02:02')
        ->and($sale->concepts)->toBeArray()
        ->and($sale->concepts)->toHaveCount(2);
});

test ('Calculo de total en SaleEntity', function(){
    $concept1 = new ConceptEntity(quantity:3, price:20.0, product_id:1);
    $concept2 = new ConceptEntity(quantity:2, price:15.0, product_id:2);

    $sale = new SaleEntity(id:1, email:"test@algo.com", sale_date:'2025-01-12 15:02:02',
        concepts:[$concept1, $concept2]);
    expect($sale->total)->toBe(90.0);
});

test('Comprobar SaleEntity sin conceptos total en $0.0', function (){
    $sale = new SaleEntity(id:1, email:"test@algo.com", sale_date:'2025-01-12 15:02:02', concepts:[]);
    expect($sale->total)->toBe(0.0);
});