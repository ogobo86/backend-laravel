<?php

use App\Business\Services\ProductService;
use App\Business\Entities\Taxes;

test('Calcula el impuesto IVA', function () {
    
    $price = 100;

    $service = new ProductService();

    $result = $service->calculateIVA($price);

    expect($result)->toBe($price * (1 + Taxes::IVA));
});
