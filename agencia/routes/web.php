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

Route::get('/form', function ()
{
    return view('formulario');
});
Route::post('/proceso2', function ()
{
    //capturamos dato enviado
    //$nombre = $_GET['nombre'];
    //$nombre = request()->input('nombre');
    //$nombre = request()->nombre;
    $nombre = request('nombre');

    //retornamos la ruta PASANDO el dato
    return view('proceso', [ 'nombre'=>$nombre ]);
});

Route::get('/listaRegiones', function ()
{
    //obtenemos listado de regiones
    $regiones = DB::select('SELECT idRegion, regNombre FROM regiones');
    return view('listaRegiones', [ 'regiones'=>$regiones ]);
});
