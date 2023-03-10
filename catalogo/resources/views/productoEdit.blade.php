@extends('layouts.plantilla')
@section('contenido')

    <h1>Modificación de un producto</h1>

    <div class="alert p-4 col-8 mx-auto shadow">
        <form action="/producto/update" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
            <div class="form-group mb-4">
                <label for="prdNombre">Nombre del Producto</label>
                <input type="text" name="prdNombre"
                       value="{{ old('prdNombre', $Producto->prdNombre) }}"
                       class="form-control" id="prdNombre">
            </div>

            <label for="prdPrecio">Precio del Producto</label>
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <div class="input-group-text">$</div>
                </div>
                <input type="number" name="prdPrecio"
                       value="{{ old('prdPrecio', $Producto->prdPrecio) }}"
                       class="form-control" id="prdPrecio" min="0" step="0.01">
            </div>

            <div class="form-group mb-4">
                <label for="idMarca">Marca</label>
                <select class="form-select" name="idMarca" id="idMarca">
                    <option value="">Seleccione una marca</option>
                @foreach( $marcas as $marca )
                    <option @selected(old('idMarca', $Producto->idMarca)==$marca->idMarca) value="{{ $marca->idMarca }}">{{ $marca->mkNombre }}</option>
                @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="idCategoria">Categoría</label>
                <select class="form-select" name="idCategoria" id="idCategoria">
                    <option value="">Seleccione una categoría</option>
            @foreach( $categorias as $categoria )
                    <option @selected( old('idCategoria', $Producto->idCategoria)==$categoria->idCategoria ) value="{{ $categoria->idCategoria }}">{{ $categoria->catNombre }}</option>
            @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="prdDescripcion">Descripción del Producto</label>
                <textarea name="prdDescripcion" class="form-control"
                          id="prdDescripcion">{{ old('prdDescripcion', $Producto->prdDescripcion) }}</textarea>
            </div>

            <div class="custom-file mt-1 mb-4">
                Imagen actual:
                <img src="/imagenes/productos/{{ $Producto->prdImagen }}" class="img-thumbnail">
            </div>

            <div class="custom-file mt-1 mb-4">
                Modificar imagen (opcional): <br>
                <input type="file" name="prdImagen"  class="custom-file-input" id="customFileLang" lang="es">
                <label class="custom-file-label" for="customFileLang" data-browse="Buscar en disco">Seleccionar Archivo: </label>
            </div>

            <input type="hidden" name="idProducto"
                   value="{{ $Producto->idProducto }}">
            <input type="hidden" name="prdImagenOld"
                   value="{{ $Producto->prdImagen }}">

            <button class="btn btn-dark mr-3 px-4">Modificar producto</button>
            <a href="/productos" class="btn btn-outline-secondary">
                Volver a panel de productos
            </a>

        </form>
    </div>

    @if( $errors->any() )
        <div class="alert alert-danger p-4 col-8 mx-auto">
            <ul>
                @foreach( $errors->all() as $error )
                    <li>
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <script>
      /*  const prdImagen = document.querySelector('input[name="prdImagen"]');
        const foto = document.querySelector('.img-thumbnail');
        prdImagen.addEventListener('change', function( evt ){
            let i = prdImagen.value;
            let j = i.substring(12, 100);
            //cambia rnombre
            foto.src = 'imagenes/productos/'+j;
        }) */
    </script>

@endsection
