<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;

// Rotas que não precisam de autenticação
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);

// Rotas que precisam de autenticação
Route::middleware('jwt.auth')->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);

    Route::apiResource('cliente', ClienteController::class);
    Route::apiResource('carro', CarroController::class);
    Route::apiResource('locacao', LocacaoController::class);
    Route::apiResource('marca', MarcaController::class);
    Route::apiResource('modelo', ModeloController::class);
});


