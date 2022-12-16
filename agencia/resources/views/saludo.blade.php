<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Vista saludo</h1>

    hoy es: {{ date('d/m/Y') }}

    <hr>

    @if( !isset($nombre) )
        Nombre no está definido
    @else
        Nombre tiene valor {{ $nombre }}
    @endif

    <hr>
    @for( $i = 1; $i < 15; $i++ )
        {{ $i }}<br>
    @endfor


    @php
        echo 'con esto te miramos feo, pero salvaste el día'
    @endphp


</body>
</html>
