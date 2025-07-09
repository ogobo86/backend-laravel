<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QueriesController;
use App\Http\Middleware\CheckValueInHeader;
use App\Http\Middleware\UppercaseName;
use Illuminate\Support\Facades\Route;


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
    ->middleware([CheckValueInHeader::class, UppercaseName::class ]); 
