# Ciclo de peticiones

<img src="../extras/imagenes/peticiones.png"> 

    Route::view('peticion', 'vista');  
    Route::get('peticion', acción ); 

> En laravel utilizamos un paradigma de peticiones  
> Le pedimos algo al enrutador y este corre un proceso 
> ***NOTA:*** hasta que trabajemos con controladores 

    Route::get('peticion', acción );

> En este caso utilizaremos un closure: 
> una función anónima autoejecutada  

    Route::get('peticion', function()
    {
        //proceso a ejecutar
    });