<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('cliente', ClienteController::class);

Route::apiResource('carro', CarroController::class);

Route::apiResource('locacao', LocacaoController::class);

Route::apiResource('marca', MarcaController::class);
//Route::match(['put', 'patch'], 'marcas/{id}', [MarcaController::class, 'update']);

Route::apiResource('modelo', ModeloController::class);
//Route::match(['put', 'patch'], 'modelos/{id}', [ModeloController::class, 'update']);
