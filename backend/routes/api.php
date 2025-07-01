<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::post("/usuario", [UsuarioController::class, "store"]);
