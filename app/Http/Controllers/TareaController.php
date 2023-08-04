<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        return Tarea::where('cod_usuario',$cod_user)
        ->orderBy('ultimo_realizado')
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'tarea' => 'required',
        ]);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        $tarea = new Tarea;
        $tarea -> tarea = $request-> tarea;
        $tarea -> frecuencia = $request-> frecuencia;
        $tarea -> cod_usuario = $cod_user;
        $tarea -> ultimo_realizado = $request-> ultimo_realizado;
        $tarea -> save();

        return $tarea;
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        $user = Auth::user();
        
        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }
        
        if($cod_user != $tarea->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            return $tarea;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        $request -> validate([
            'tarea'    => 'required',
           // 'cod_usuario' => 'required'
        ]);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if($cod_user != $tarea->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $tarea -> tarea = $request-> tarea;
            $tarea -> frecuencia = $request-> frecuencia;
            $tarea -> ultimo_realizado = $request-> ultimo_realizado;
            $tarea -> cod_usuario = $cod_user;
            $tarea -> update();

            return $tarea;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tarea = Tarea::find($id);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if(is_null($tarea)){
            return response("Error", 404);
        }

        if($cod_user != $tarea->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $tarea -> delete();

            return response()->noContent();
        }
    }
}
