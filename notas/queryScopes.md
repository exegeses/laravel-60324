# Query Scopes

> lod Query Scopes con consultas en el model para
> separar del controller parte de una consulta

** en el model **
    public function scopeMenor( $query, monto ){  
        return $query->where( 'prdPrecio', '<', $monto );  
    }  

** en el controller **

    Producto::menor(1000)->paginate(7);

** en el model **
    public function scopeAlfa( $query )  
    {  
        return $query->orderBy('mkNombre');   
    }  

** en el controller **

    $marcas = Marca::alfa()->paginate(7);

