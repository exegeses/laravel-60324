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

#############################
#### CRUD de regiones
Route::get('/regiones', function ()
{
    //obtenemos listado de regiones
    $regiones = DB::select('SELECT idRegion, regNombre FROM regiones');
    return view('regiones', ['regiones'=>$regiones]);
});
Route::get('/region/create', function()
{
    return view('regionCreate');
});
Route::post('/region/store', function ()
{
    //capturamos dato enviado por el form
    $regNombre = request('regNombre');

    try {
        //insertamos datos;
        DB::insert('INSERT INTO regiones
                    ( regNombre )
                  VALUE
                    ( :regNombre )',
            [ $regNombre ]
        );
        //redirección con mensaje ok
        return redirect('/regiones')
            ->with(
                [
                    'mensaje'=>'Región: '.$regNombre.' agregada correctamente',
                    'css'=>'success'
                ]
            );
    }catch( \Throwable $th ){
        //redirección con mensaaje error
        return redirect('/regiones')
                    ->with(
                        [
                            'mensaje'=>'No se pudo agregar la región: '.$regNombre,
                            'css'=>'danger'
                        ]
                    );
    }
});
Route::get('/region/edit/{id}', function ( $id )
{
    //obtenemos datos de una region filtrada por su id
    /*$region = DB::select(
            'SELECT idRegion, regNombre
                FROM regiones
                WHERE idRegion = :id',
                                [ $id ]
            );*/
    $region = DB::table('regiones')
                    ->where('idRegion', $id)->first();
    return view('regionEdit', [ 'region'=>$region ]);
});
Route::patch('/region/update', function ()
{
    //capturamos datos enviados por el form
    $regNombre = request('regNombre');
    $idRegion = request('idRegion');
    try{
        /*DB::update('UPDATE regiones
                        SET regNombre = :regNombre
                        WHERE idRegion = :idRegion',
                                [ $regNombre, $idRegion ]
                    );*/
        DB::table('regiones')
                    ->where('idRegion', $idRegion)
                    ->update([ 'regNombre'=>$regNombre ]);
        //redirección con mensaaje ok
        return redirect('/regiones')
            ->with(
                [
                    'mensaje'=>'Región: '.$regNombre.' modificada correctamente',
                    'css'=>'success'
                ]
            );

    }catch( \Throwable $th ){
        //redirección con mensaaje error
        return redirect('/regiones')
            ->with(
                [
                    'mensaje'=>'No se pudo modificar la región: '.$regNombre,
                    'css'=>'danger'
                ]
            );
    }
});
Route::get('/region/delete/{id}/{region}', function ( $id, $regNombre )
{
    //chequeo si hay un DESTINO con ese idRegion
    $cantidad = DB::table('destinos')
                        ->where('idRegion', $id)
                        ->count();
    if( $cantidad ){
        //redirección con mensaaje error
        return redirect('/regiones')
            ->with(
                [
                    'mensaje'=>'No se puede eliminar la región: '.$regNombre.' ya que tiene destinos relacionados',
                    'css'=>'warning'
                ]
            );
    }
    //retornamos vista de confirmación
    return view('regionDelete',
                    [
                        'idRegion'=>$id,
                        'regNombre'=>$regNombre
                    ]
                );
});
Route::delete('/region/destroy', function ()
{
    $regNombre = request('regNombre');
    $idRegion = request('idRegion');
    try {
        /*DB::delete('DELETE FROM regiones
                        WHERE idRegion = :idRegion',
                                        [ $idRegion ]
                    );*/
        DB::table('regiones')
                    ->where('idRegion', $idRegion)
                    ->delete();
        //redirección con mensaaje ok
        return redirect('/regiones')
            ->with(
                [
                    'mensaje'=>'Región: '.$regNombre.' eliminada correctamente',
                    'css'=>'success'
                ]
            );
    }catch( \Throwable $th ){
        //redirección con mensaaje error
        return redirect('/regiones')
            ->with(
                [
                    'mensaje'=>'No se pudo eliminar la región: '.$regNombre,
                    'css'=>'danger'
                ]
            );
    }
});

#########################################
#####  CRUD de destinos
Route::get('/destinos', function ()
{
    //obtenemos listado de destinos
    /*$destinos = DB::select('SELECT idDestino, destNombre, regNombre, destPrecio
                                FROM destinos d
                                  JOIN regiones r
                                   ON d.idRegion = r.idRegion');*/
    $destinos = DB::table('destinos as d')
                        ->join('regiones as r', 'd.idRegion', '=', 'r.idRegion')
                        ->get();
    return view('destinos', [ 'destinos'=>$destinos ]);
});

Route::get('/destino/create', function ()
{
    //obtenemos listado de regiones
    $regiones = DB::table('regiones')->get();
    return view('destinoCreate', [ 'regiones'=>$regiones ]);
});
Route::post('/destino/store', function()
{
    $destNombre = request('destNombre');
    $idRegion = request('idRegion');
    $destPrecio = request('destPrecio');
    $destAsientos = request('destAsientos');
    $destDisponibles = request('destDisponibles');
    try{
        /* Raw SQL */
        /*DB::insert(
                    'INSERT INTO destinos
                        ( destNombre, idRegion, destPrecio, destAsientos, destDisponibles )
                        VALUE
                        ( :destNombre, :idRegion, :destPrecio, :destAsientos, :destDisponibles )',
                        [ $destNombre, $idRegion, $destPrecio, $destAsientos, $destDisponibles ]
                    );*/
        DB::table('destinos')
                ->insert(
                    [
                        'destNombre'=>$destNombre,
                        'idRegion'=>$idRegion,
                        'destPrecio'=>$destPrecio,
                        'destAsientos'=>$destAsientos,
                        'destDisponibles'=>$destDisponibles
                    ]
                );
        return redirect('/destinos')
                    ->with(
                        [
                            'mensaje'=>'Destino: '.$destNombre.' agregado correctamente.',
                            'css'=>'success'
                        ]
                    );
    }
    catch( Throwable $th ){
        return redirect('/destinos')
            ->with(
                [
                    'mensaje'=>'No se pudo agregar el destino: '.$destNombre,
                    'css'=>'danger'
                ]
            );
    }

});
