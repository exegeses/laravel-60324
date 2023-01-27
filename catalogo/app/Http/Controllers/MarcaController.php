<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtenemos listado de marcas
        //$marcas = DB::table('marcas')->get();
        $marcas = Marca::orderBy('mkNombre')->paginate(7);
        return view('marcas', [ 'marcas'=>$marcas ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marcaCreate');
    }

    private function validarForm( Request $request )
    {
        $request->validate(
            // [ 'campo'=>'reglas' ], [ 'campo.regla'=>'mensaje' ]
            [
                'mkNombre'=>'required|min:2|max:30|unique:marcas,mkNombre'
            ],
            [
                'mkNombre.required'=>'El campo "Nombre de la marca" es obligatorio',
                'mkNombre.min'=>'El campo "Nombre de la marca" debe tener al menos 2 caractéres',
                'mkNombre.max'=>'El campo "Nombre de la marca" debe tener 30 caractéres como máximo',
                'mkNombre.unique'=>'Nombre de la marca ya existe en la base de datos'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mkNombre = $request->mkNombre;
        //validación
        $this->validarForm($request);
        //almacenamos en tabla
        try {
            //intanciamos
            $Marca = new Marca;
            //asignamos valores a atributos
            $Marca->mkNombre = $mkNombre;
            //guardamos
            $Marca->save();
            //redirección con mensaje de ok
            return redirect('/marcas')
                    ->with(
                        [
                            'mensaje'=>'Marca: '.$mkNombre.' agregada correctamente',
                            'css'=>'success'
                        ]
                    );
        }
        catch ( \Throwable $th ){
            return redirect('/marcas')
                ->with(
                    [
                        'mensaje'=>'No se pudo agregar la marca: '.$mkNombre,
                        'css'=>'danger'
                    ]
                );
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show(Marca $marca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        //obtenemos datos de una marca por su id
        //$Marca = DB::table('marcas')->where('idMarca', $id)->first();
        $Marca = Marca::find($id);
        //retu¡ornamos vista pasando datos de la marca
        return view('marcaEdit', [ 'Marca'=>$Marca ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //capturamos dato enviador por el form
        $mkNombre = $request->mkNombre;
        $idMarca = $request->idMarca;

        //validación
        $this->validarForm($request);
        try {
            //obtenemos una marca por su id
            $Marca = Marca::find($idMarca);
            //modificación de atributos
            $Marca->mkNombre = $mkNombre;
            //almacenamos cambios
            $Marca->save();
            //redirección con mensaje ok;
            return redirect('/marcas')
                ->with(
                    [
                        'mensaje'=>'Marca: '.$mkNombre.' modificada correctamente',
                        'css'=>'success'
                    ]
                );
        }
        catch ( \Throwable $th ){
            return redirect('/marcas')
                ->with(
                    [
                        'mensaje'=>'No se pudo modificar la marca: '.$mkNombre,
                        'css'=>'danger'
                    ]
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca)
    {
        //
    }
}
