<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

####### CRUD de marcas
use App\Http\Controllers\MarcaController;
Route::get('/marcas', [ MarcaController::class, 'index' ] );
Route::get('/marca/create', [ MarcaController::class, 'create' ] );
Route::post('/marca/store', [ MarcaController::class, 'store' ]);
Route::get('/marca/edit/{id}', [ MarcaController::class, 'edit' ]);
Route::put('/marca/update', [ MarcaController::class, 'update' ]);
Route::get('/marca/confirm/{id}/{marca}', [ MarcaController::class, 'confirm' ]);
Route::delete('/marca/destroy', [ MarcaController::class, 'destroy' ]);

####### CRUD de productos
use App\Http\Controllers\ProductoController;
Route::get('/productos', [ ProductoController::class, 'index' ]);
Route::get('/producto/create', [ ProductoController::class, 'create' ]);
Route::post('/producto/store', [ ProductoController::class, 'store' ]);
Route::get('/producto/edit/{id}', [ ProductoController::class, 'edit' ]);
Route::put('/producto/update', [ ProductoController::class, 'update' ]);
Route::get('/producto/confirm/{id}', [ ProductoController::class, 'confirm' ]);
Route::delete('/producto/delete', [ ProductoController::class, 'destroy' ]);
