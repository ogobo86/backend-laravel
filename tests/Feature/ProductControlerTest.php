<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class); // Recrea la base de datos en cada test

// Deshabilitacion de middleware
beforeEach(function(){
    $this->withoutMiddleware(\Tymon\JWTAuth\Http\Middleware\Authenticate::class);
});

test('example', function () {
    // Creacion de usuario
    $user = User::factory()->create();
    // Autenticacion obtencion de token
    $token =JWTAuth::fromUser($user);
    
    // Creacion de productos.
    Product::factory()->count(15)->create();

    $response = $this->withHeader("Authorization", "Bearer $token") // Se manda token
        ->getJson('/api/product?per_page=5&page=0');

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonCount(5) // Valida el total de elementos
        ->assertJsonStructure([
            '*'=>['id','name','price','description','category_id']
        ]); 

    // doble validacion
    $data = $response->json();
    expect(count($data))->toBe(5);
});

// En este punto la BD esta vacia

test ('Crear producto de manera correcta', function (){
    // Creacion de categoria
    $category = Category::factory()->create();
    // Info del Producto
    $productData = [
        'name' => 'Producto A',
        'price' => 99.9,
        'description' => 'Descripcion de producto A',
        'category_id'=> $category->id,
    ];

    // Se realiza solicitud
    $response = $this->postJson(route("product.store"), $productData);

    $response->assertStatus(Response::HTTP_OK)
        // verfica la estructura
        ->assertJsonStructure(['id','name','price','description','category_id']);

    // Validacion de la info en la BD
    $this->assertDatabaseHas('product', $productData);
});

test('Datos de producto invalidos al mandarse a crear', function(){
    
    $invalidProductData = [
        'name' => '',
        'price' => 'texto',
        'description' => str_repeat("a", 3000),
        'category_id' => 999999,
    ];


    $response = $this->postJson(route('product.store'), $invalidProductData);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['id','name','price','description','category_id']);

});

test ('Actualizar un producto correctamente', function(){
    $category = Category::factory()->create();

    $product = Product::factory()->create([
        'category_id' => $category -> id
    ]);

    $newCategory = Category::factory()->create();

    $data = [
        'name' => 'Producto Actulizado',
        'price' => 199.9,
        'description' => "Una descripcion",
        'category_id' => $newCategory->id
    ];

    $response = $this->putJson(route("product.update", $product ), $data);

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson([
            'message' => 'Producto actualizado exitosamente', 
            'product' => [
                'id' => $product->id,
                'name' => 'Producto Actulizado',
                'price' => 199.9,
                'description' => "Una descripcion",
                'category_id' => $newCategory->id
            ]
        ]);

    $this->assertDatabaseHas("product", [
        'id' => $product->id,
        'name' => 'Producto Actulizado',
        'price' => 199.9,
        'description' => "Una descripcion",
        'category_id' => $newCategory->id
    ]);
});

test ('Falla si no se envia category_id', function(){
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id'=>$category->id]);

    $data = [
        'name' => 'Producto sin categoria',
        'price' => 150.50,
        'description' => 'Una descripcion',
    ];

    $response=$this->putJson(route('product.update', $product), $data);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['category_id']);
});

test ('Falla si category_id no existe en la base de datos', function(){
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id'=>$category->id]);

    $data = [
        'name' => 'Producto sin categoria',
        'price' => 150.50,
        'category_id' => 999999,
    ];

    $response=$this->putJson(route('product.update', $product), $data);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['category_id']);
});

test ('Elimina un producto correctamente', function(){
    $product = Product::factory()->create();

    $response = $this->deleteJson(route('product.destroy', $product));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson(['message' => 'Producto eliminado']);

    // $this->assertDatabaseMissing('product', $product->id );
    $this->assertSoftDelete('product', $product->id );
});


test ('Falla al intentar un producto que no existe', function(){ 
    $response =$this->deleteJson(route('product.destroy', ['product'=>999999]));

    $response->assertStatus(Response::HTTP_NOT_FOUND);
});

