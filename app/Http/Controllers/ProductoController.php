<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        //return Producto::all();
        return Producto::where('cod_usuario',$user->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'producto'    => 'required',
            //'cod_usuario' => 'required'
        ]);

        $user = Auth::user();

        $producto = new Producto;
        $producto -> producto = $request-> producto;
        $producto -> cod_usuario = $user->id;
        $producto -> save();

        return $producto;
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $user = Auth::user();
        
        if($user->id != $producto->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            return $producto;
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $request -> validate([
            'producto'    => 'required',
            'cod_usuario' => 'required'
        ]);

        $user = Auth::user();

        if($user->id != $producto->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $producto -> producto = $request-> producto;
            $producto -> cod_usuario = $request-> cod_usuario;
            $producto -> update();

            return $producto;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        $user = Auth::user();

        if(is_null($producto)){
            return response("Error", 404);
        }

        if($user->id != $producto->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $producto -> delete();

            return response()->noContent();
        }
    }
}
