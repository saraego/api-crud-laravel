<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuariosController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UsuariosController::class)->group(function (){
    Route::get('/usuarios','index');
    Route::post('/usuario','store');
    Route::get('/usuario/{id}','show');
    Route::put('/usuario/{id}','update');
    Route::delete('/usuario/{id}','destroy');
});
