<!DOCTYPE html>

<html>
    <head>
        <h1>Recuperación de contraseña</h1>
    </head>
    <body>
        <h4>Hola {{$user-> name}}</h4>
        <h4>Pulsa en el siguiente enlace para resetear la contraseña</h4>
        <a href="{{ url('http://localhost:8080/reset/'.$user->id.'/'.$token) }}">Resetear contraseña</a>
    </body>
</html>

<!-- <a href="{{ url("/usuarios/{$user->id}") }}">Ver detalles</a>
<a href="{{ url('/usuarios/'.$user->id) }}">Ver detalle</a> -->