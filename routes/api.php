<?php

use App\Http\Controllers\Api\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProdutoController::class, 'index']);
Route::get('/products', [ProdutoController::class, 'products']);
