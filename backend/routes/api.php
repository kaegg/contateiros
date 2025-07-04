<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\SecaoController;
use App\Http\Controllers\UsuarioController;

Route::get("/funcao", [FuncaoController::class, "index"]);
Route::get("/secao" , [SecaoController::class , "index"]);

Route::post("/usuario", [UsuarioController::class, "store"]);
Route::get("/usuario" , [UsuarioController::class, "index"]);