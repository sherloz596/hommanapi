<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DespensaController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\ListaCompraController;
use App\Http\Controllers\AlmacenajeController;
use App\Http\Controllers\ListaCompraLinController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\TareaController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);
Route::post('recovery', [AuthController::class,'recoveryPass']);
Route::post('reset', [AuthController::class,'resetPassword']);



Route::middleware('auth:sanctum')->group(function (){

    Route::get('logout', [AuthController::class,'logout']);
    Route::post('invitar', [AuthController::class,'invitar']);
    Route::post('change_lan', [AuthController::class,'changeLan']);
    Route::apiResource('despensas',DespensaController::class);
    Route::apiResource('units',UnitController::class);
    Route::apiResource('productos',ProductoController::class);
    Route::apiResource('tareas',TareaController::class);
    Route::apiResource('favoritos',FavoritoController::class);
    Route::apiResource('lista_compra',ListaCompraController::class);
    Route::apiResource('lista_compra_lin',ListaCompraLinController::class);
    Route::apiResource('almacenajes',AlmacenajeController::class);
    Route::apiResource('compras',CompraController::class);
    Route::get('almacenaje/{despensa}', [AlmacenajeController::class, 'vistaDespensa']);
    Route::get('lista_curso', [ListaCompraController::class, 'getEnCurso']);
    Route::put('up_comprar/{producto}', [ProductoController::class, 'upComprar']);
    Route::get('compra', [ListaCompraLinController::class, 'verCompra']);
    Route::get('compra_curso', [ListaCompraLinController::class, 'verCompraCurso']);
    Route::put('up_estado', [ListaCompraLinController::class, 'upEstado']);
    Route::get('ver_anteriores/{lista_compra}', [ListaCompraLinController::class, 'verAnteriores']);
});

