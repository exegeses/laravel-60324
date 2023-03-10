<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $primaryKey = 'idProducto';
    public $timestamps = false;

    /*### mátodos de relación ###*/
    public function getMarca()
    {
        return $this->belongsTo(
                Marca::class,
             'idMarca',
                'idMarca'
        );
        /* JOIN marcas
            ON productos.idMarca = marcas.idMarca
        */
    }

    public function getCategoria()
    {
        return $this->belongsTo(
               Categoria::class,
            'idCategoria',
              'idCategoria'
        );
    }
}
