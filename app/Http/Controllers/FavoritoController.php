<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
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
        //return Favorito::all();
        return Favorito::where('cod_usuario',$cod_user)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'cod_usuario' => 'required',
            //'cod_producto' => 'required'
        ]);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        $favorito = new Favorito;
        $favorito -> cod_usuario = $request-> cod_usuario;
        $favorito -> cod_producto = $cod_user;
        $favorito -> save();

        return $favorito;
    }

    /**
     * Display the specified resource.
     */
    public function show(Favorito $favorito)
    {
        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }
        
        if($cod_user != $favorito->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            return $favorito;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favorito $favorito)
    {
        $request -> validate([
            //'cod_usuario' => 'required',
            'cod_producto' => 'required',
            'nombre'    => 'required'
        ]);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if($cod_user != $favorito->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            //$favorito -> cod_usuario = $request-> cod_usuario;
            $favorito -> cod_producto = $request-> cod_producto;
            $favorito -> nombre = $request-> nombre;
            $favorito -> update();

            return $favorito;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $favorito = Favorito::find($id);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if(is_null($favorito)){
            return response("Error", 404);
        }

        if($cod_user != $favorito->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $favorito -> delete();

            return response()->noContent();
        }
    }
}
