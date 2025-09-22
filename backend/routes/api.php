<?php

use App\Http\Controllers\AtividadeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\InstalacaoController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\LocalImagemController;
use App\Http\Controllers\LocalAtividadeController;
use App\Http\Controllers\LocalInstalacaoController;
use App\Http\Controllers\LocalAvaliacaoController;
use App\Http\Controllers\SecaoController;
use App\Http\Controllers\UsuarioController;

Route::get("/funcao", [FuncaoController::class, "index"]);

Route::get("/secao" , [SecaoController::class , "index"]);

Route::get("/usuario" , [UsuarioController::class, "index"]);
Route::post("/usuario", [UsuarioController::class, "store"]);
Route::put("/usuario/{usuario}", [UsuarioController::class, "update"]);
Route::delete('/usuario/{usuario}', [UsuarioController::class, 'destroy']);
Route::put('/usuario/ativar/{usuario}', [UsuarioController::class, 'ativar']);

Route::get("/atividade", [AtividadeController::class, "index"]);
Route::post("/atividade", [AtividadeController::class, "store"]);
Route::put('/atividade/{atividade}', [AtividadeController::class, 'update']);
Route::delete('/atividade/{atividade}', [AtividadeController::class, 'destroy']);
Route::put('/atividade/ativar/{atividade}', [AtividadeController::class, 'ativar']);

Route::get("/instalacao", [InstalacaoController::class, "index"]);
Route::post("/instalacao", [InstalacaoController::class, "store"]);
Route::put('/instalacao/{instalacao}', [InstalacaoController::class, 'update']);
Route::delete('/instalacao/{instalacao}', [InstalacaoController::class, 'destroy']);
Route::put('/instalacao/ativar/{instalacao}', [InstalacaoController::class, 'ativar']);

Route::get("/local", [LocalController::class, "index"]);
Route::post("/local", [LocalController::class, "store"]);
Route::get("/local/{local}", [LocalController::class, "show"]);
Route::put("/local/{local}", [LocalController::class, "update"]);
Route::delete("/local/{local}", [LocalController::class, "destroy"]);

// Rotas para dados específicos do local
Route::get("/local/{local}/imagens", [LocalController::class, "getImages"]);
Route::get("/local/{local}/atividades", [LocalController::class, "getActivities"]);
Route::get("/local/{local}/instalacoes", [LocalController::class, "getFacilities"]);
Route::get("/local/{local}/avaliacoes", [LocalController::class, "getRatings"]);

// Rotas para imagens de locais
Route::get("/local/{local}/imagens", [LocalImagemController::class, "index"]);
Route::get("/local-imagem/{localImagem}", [LocalImagemController::class, "show"]);
Route::post("/local-imagem", [LocalImagemController::class, "store"]);
Route::delete("/local-imagem/{localImagem}", [LocalImagemController::class, "destroy"]);

// Rotas para atividades de locais
Route::get("/local/{local}/atividades", [LocalAtividadeController::class, "index"]);
Route::post("/local-atividade", [LocalAtividadeController::class, "store"]);
Route::delete("/local-atividade/{localAtividade}", [LocalAtividadeController::class, "destroy"]);

// Rotas para instalações de locais
Route::get("/local/{local}/instalacoes", [LocalInstalacaoController::class, "index"]);
Route::post("/local-instalacao", [LocalInstalacaoController::class, "store"]);
Route::delete("/local-instalacao/{localInstalacao}", [LocalInstalacaoController::class, "destroy"]);

// Rotas para avaliações de locais
Route::get("/local/{local}/avaliacoes", [LocalAvaliacaoController::class, "index"]);
Route::post("/local-avaliacao", [LocalAvaliacaoController::class, "store"]);
Route::put("/local-avaliacao/{localAvaliacao}", [LocalAvaliacaoController::class, "update"]);
Route::delete("/local-avaliacao/{localAvaliacao}", [LocalAvaliacaoController::class, "destroy"]);