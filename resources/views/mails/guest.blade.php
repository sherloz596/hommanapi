<!DOCTYPE html>

<html>
    <head>
        <h1>¡Te han invitado a utilizar HommanApp!</h1>
    </head>
    <body>
        <h4>{{$user-> name}} te ha invitado a unirte a su espacio de hommanApp</h4>
        <h4>Pulsa en el siguiente enlace para registrarte</h4>
        <a href="{{ url('http://localhost:8080/registro-guest/'.$user->id.'/'.$email) }}">Regístrate</a>
    </body>
</html>