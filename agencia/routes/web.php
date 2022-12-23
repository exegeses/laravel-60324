<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::view('peticion', 'vista');
Route::view('/hola.html', 'saludo');

Route::get('/proceso', function()
{
    //acá realizamos nuestra magia
    return view('saludo');
});

Route::get('/inicio', function ()
{
    return view('inicio');
});
