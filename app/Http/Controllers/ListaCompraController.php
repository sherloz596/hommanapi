<?php

namespace App\Http\Controllers;

use App\Models\Lista_compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListaCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        //return Lista_compra::all();
        return Lista_compra::where('cod_usuario',$user->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            //'cod_usuario' => 'required',
            'cod_producto' => 'required',
            'nombre'    => 'required'
        ]);

        $user = Auth::user();

        $lista_compra = new Lista_compra;
        $lista_compra -> cod_usuario = $user->id;
        $lista_compra -> cod_producto = $request-> cod_producto;
        $lista_compra -> nombre = $request-> nombre;
        $lista_compra -> save();

        return $lista_compra;
    }

    /**
     * Display the specified resource.
     */
    public function show(Lista_compra $lista_compra)
    {
        $user = Auth::user();
        
        if($user->id != $lista_compra->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            return $lista_compra;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lista_compra $lista_compra)
    {
        $request -> validate([
            //'cod_usuario' => 'required',
            'cod_producto' => 'required',
            'nombre'    => 'required'
        ]);

        $user = Auth::user();

        if($user->id != $lista_compra->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
        // $lista_compra -> cod_usuario = $request-> cod_usuario;
            $lista_compra -> cod_producto = $request-> cod_producto;
            $lista_compra -> nombre = $request-> nombre;
            $lista_compra -> update();

            return $lista_compra;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lista_compra = Lista_compra::find($id);

        $user = Auth::user();

        if(is_null($lista_compra)){
            return response("Error", 404);
        }

        if($user->id != $lista_compra->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $lista_compra -> delete();

            return response()->noContent();
        }
    }
}
