<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::view('peticion', 'vista');
Route::view('/hola.html', 'saludo');

Route::get('/proceso', function()
{
    //acá realizamos nuestra megia
    return view('saludo');
});
