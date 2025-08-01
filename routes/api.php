<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QueriesController;
use App\Http\Middleware\CheckValueInHeader;
use App\Http\Middleware\LogRequests;
use App\Http\Middleware\UppercaseName;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfoController;

Route::get('/test',function(){
    return "El backen funciona correctamente";
});

Route::get('/backend', [BackendController::class, "getAll"])
    ->middleware("checkvalue");
    
Route::get('/backend/{id?}', [BackendController::class, "get"]);
Route::post('/backend', [BackendController::class, "create"]);
Route::put('/backend/{id}', [BackendController::class, 'update']);
Route::delete('/backend/{id}', [BackendController::class, 'delete']);

# QUERIES CONTROLES ROUTE

Route::get("/query", [QueriesController::class, "get"]); // Lista los registros
Route::get("/query/{id}", [QueriesController::class, "getById"]); // Obtener registro 
Route::get("/query/method/names", [QueriesController::class, "getNames"]); // Seleccionar por campos
Route::get("/query/method/search/{name}/{precio}", [QueriesController::class, "searchName"]); // Filtrado de informacion WHERE
Route::get("/query/method/searchString/{value}", [QueriesController::class, "searchString"]); // Filtrado de informacion LIKE
Route::post("/query/method/advancedSearch", [QueriesController::class, "advancedSearch"]); // Busqueda dinamica
Route::get("/query/method/join", [QueriesController::class, "join"]); // JOIN
Route::get("/query/method/groupby", [QueriesController::class, "groupBy"]); // GROUP BY

# CRUD EN LARABEL
Route::apiResource("/product", ProductController::class)
# USO DE MIDDLEWARE
    ->middleware([
        "jwt.auth", // Token para acceder a rutas
        LogRequests::class
    ]); 

// Registro de usuarios
Route::post('/register', [AuthController::class, 'register']);
// Login de ususarios
Route::post('/login', [AuthController::class, 'login'])->name("login");

// agrupacion 
Route::middleware("jwt.auth") -> group(function(){
    // saber quien esta conectado
    Route::get('who', [AuthController::class, 'who']);
    // logout
    Route::post('logout', [AuthController::class, 'logout']);
    // Refresh
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::get("/info/message", [InfoController::class, 'message']);

Route::get("/info/tax/{id}", [Infocontroller::class, 'iva']);

// Encryptor
Route::get("/info/encrypt/{data}", [InfoController::class, 'encrypt']);
Route::get("/info/decrypt/{data}", [InfoController::class, 'decrypt']);
Route::get("/info/encryptEmail/{id}", [InfoController::class, 'encryptEmail']);

Route::get("/info/singleton", [InfoController::class, 'singleton']);

Route::get("/info/encryptEmail2/{id}", [InfoController::class, 'encryptEmail2']);