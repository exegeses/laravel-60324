<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtenemos listado de productos
        $productos = Producto::with(['getMarca', 'getCategoria'])
                            ->paginate(7);
        return view('productos', [ 'productos'=>$productos ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //obtenemos listados de marcas y categorias
        $marcas = Marca::all();
        $categorias = Categoria::all();
        return view('productoCreate',
            [
                'marcas'=>$marcas,
                'categorias'=>$categorias
            ]
        );
    }

    private function validarForm( Request $request, $idProducto = null )
    {
        $request->validate(
            [
                'prdNombre'=>'required|unique:productos,prdNombre,'.$idProducto.',idProducto|min:3|max:75',
                'prdPrecio'=>'required|numeric|min:0',
                'idMarca'=>'required',
                'idCategoria'=>'required',
                'prdDescripcion'=>'max:255',
                'prdImagen'=>'mimes:jpg,jpeg,png,gif,webp,svg|max:2048'
            ],
            [
                'prdNombre.required'=>'El campo "Nombre del producto" es obligatorio.',
                'prdNombre.unique'=>'El "Nombre del producto" ya existe.',
                'prdNombre.min'=>'El campo "Nombre del producto" debe tener como mínimo 3 caractéres.',
                'prdNombre.max'=>'El campo "Nombre" debe tener 75 caractéres como máximo.',
                'prdPrecio.required'=>'Complete el campo Precio.',
                'prdPrecio.numeric'=>'Complete el campo Precio con un número.',
                'prdPrecio.min'=>'Complete el campo Precio con un número mayor a 0.',
                'idMarca.required'=>'Seleccione una marca.',
                'idCategoria.required'=>'Seleccione una categoría.',
                'prdDescripcion.max'=>'Complete el campo Descripción con 255 caractéres como máxino.',
                'prdImagen.mimes'=>'Debe ser una imagen.',
                'prdImagen.max'=>'Debe ser una imagen de 2MB como máximo.'
            ]
        );
    }

    private function subirImagen( Request $request ) : string
    {
        //si no enviaron archivo  store()
        $prdImagen = 'noDisponible.png';

        //si no enviaron archivo  update()
        if( $request->has('prdImagenOld') ){
            $prdImagen = $request->prdImagenOld;
        }

        //si enviaron imagen
        if( $request->file('prdImagen') ){
            $file = $request->file('prdImagen');
            //renombrado
            $time = microtime(true);
            $ext = $file->getClientOriginalExtension();
            $prdImagen = $time.'.'.$ext;
            /* subir archivo  en /imagenes/productos */
            $file->move( public_path('imagenes/productos/'), $prdImagen );
        }

        return $prdImagen;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validación
        $this->validarForm($request);
        $prdNombre = $request->prdNombre;
        $prdPrecio = $request->prdPrecio;
        $idMarca = $request->idMarca;
        $idCategoria = $request->idCategoria;
        $prdDescripcion = $request->prdDescripcion;
        $prdImagen = $this->subirImagen($request);
        $prdActivo = 1;
        try {
            $Producto = new Producto;
            $Producto->prdNombre = $prdNombre;
            $Producto->prdPrecio = $prdPrecio;
            $Producto->idMarca = $idMarca;
            $Producto->idCategoria = $idCategoria;
            $Producto->prdDescripcion = $prdDescripcion;
            $Producto->prdImagen = $prdImagen;
            $Producto->prdActivo = $prdActivo;
            $Producto->save();
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'Producto: '.$prdNombre.' agregado correctamente',
                        'css'=>'success'
                    ]
                );
        }
        catch ( \Throwable $th ){
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'No se pudo agregar el producto: '.$prdNombre,
                        'css'=>'danger'
                    ]
                );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit( $idProducto )
    {
        //obtenemos datos de un producto por su id
        $Producto = Producto::find($idProducto);
        //obtenemos listadod e marcas y de categorías
        $marcas = Marca::all();
        $categorias = Categoria::all();
        return view('productoEdit',
            [
                'Producto'=>$Producto,
                'marcas'=>$marcas,
                'categorias'=>$categorias
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validación
        $this->validarForm($request, $request->idProducto);
        $idProducto = $request->idProducto;
        $prdNombre = $request->prdNombre;
        $prdPrecio = $request->prdPrecio;
        $idMarca = $request->idMarca;
        $idCategoria = $request->idCategoria;
        $prdDescripcion = $request->prdDescripcion;
        $prdImagen = $this->subirImagen($request);
        try{
            $Producto = Producto::find($idProducto);
            $Producto->prdNombre = $prdNombre;
            $Producto->prdPrecio = $prdPrecio;
            $Producto->idMarca = $idMarca;
            $Producto->idCategoria = $idCategoria;
            $Producto->prdDescripcion = $prdDescripcion;
            $Producto->prdImagen = $prdImagen;
            $Producto->save();
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'Producto: '.$prdNombre.' modificado correctamente',
                        'css'=>'success'
                    ]
                );
        }
        catch ( \Throwable $th ){
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'No se pudo modificar el producto: '.$prdNombre,
                        'css'=>'danger'
                    ]
                );
        }
    }

    public function confirm($id)
    {
        //obtenemos datos de un producto por su id
        $Producto = Producto::with(['getMarca', 'getCategoria'])->find($id);
        return view('productoDelete', [ 'Producto'=>$Producto ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request )
    {
        $prdNombre = $request->prdNombre;
        try {
            Producto::destroy( $request->idProducto );
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'Producto: '.$prdNombre.' eliminado correctamente',
                        'css'=>'success'
                    ]
                );
        }
        catch ( \Throwable $th ){
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'No se pudo eliminar el producto: '.$prdNombre,
                        'css'=>'danger'
                    ]
                );
        }
    }
}
