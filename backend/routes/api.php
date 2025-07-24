<?php

use App\Http\Controllers\AtividadeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\InstalacaoController;
use App\Http\Controllers\SecaoController;
use App\Http\Controllers\UsuarioController;

Route::get("/funcao", [FuncaoController::class, "index"]);

Route::get("/secao" , [SecaoController::class , "index"]);

Route::get("/usuario" , [UsuarioController::class, "index"]);
Route::post("/usuario", [UsuarioController::class, "store"]);
Route::put("/usuario/{usuario}", [UsuarioController::class, "update"]);
Route::delete('/usuario/{usuario}', [UsuarioController::class, 'destroy']);

Route::get("/atividade", [AtividadeController::class, "index"]);
Route::post("/atividade", [AtividadeController::class, "store"]);

Route::get("/instalacao", [InstalacaoController::class, "index"]);
Route::post("/instalacao", [InstalacaoController::class, "store"]);