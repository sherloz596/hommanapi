<?php

namespace App\Http\Controllers;

use App\Models\Almacenaje;
use App\Models\Despensa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlmacenajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        //return Almacenaje::all();

        return Almacenaje::where('cod_usuario',$user->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            //'cod_usuario'    => 'required',
            'cod_producto'   => 'required',
            'cod_despensa'   => 'required',
            'cod_unidad'     => 'required',
            'cantidad'       => 'required',
           // 'fec_almac' => 'required'
        ]);

        $user = Auth::user();

        $almacenaje = new Almacenaje;
        $almacenaje -> cod_usuario    = $user->id;
        $almacenaje -> cod_producto   = $request-> cod_producto;
        $almacenaje -> cod_despensa   = $request-> cod_despensa;
        $almacenaje -> cod_unidad     = $request-> cod_unidad;
        $almacenaje -> cantidad       = $request-> cantidad;
        $almacenaje -> fec_almac = now();
        $almacenaje -> save();

        return $almacenaje;
    }

    /**
     * Display the specified resource.
     */
    public function show(Almacenaje $almacenaje)
    {
        $user = Auth::user();
        if($user->id != $almacenaje->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            return $almacenaje;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Almacenaje $almacenaje)
    {
        $request -> validate([
            //'cod_usuario'    => 'required',
            'cod_producto'   => 'required',
            'cod_despensa'   => 'required',
            'cod_unidad'     => 'required',
            'cantidad'       => 'required',
            'fec_almac'      => 'required'
        ]);

        $user = Auth::user();
        if($user->id != $almacenaje->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
           // $almacenaje -> cod_usuario    = $request-> cod_usuario;
            $almacenaje -> cod_producto   = $request-> cod_producto;
            $almacenaje -> cod_despensa   = $request-> cod_despensa;
            $almacenaje -> cod_unidad     = $request-> cod_unidad;
            $almacenaje -> cantidad       = $request-> cantidad;
            $almacenaje -> fec_almac      = $request-> fec_almac;
            $almacenaje -> update();

            return $almacenaje;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $almacenaje = Almacenaje::find($id);

        $user = Auth::user();

        if(is_null($almacenaje)){
            return response("Error", 404);
        }

        if($user->id != $almacenaje->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $almacenaje -> delete();

            return response()->noContent();
        }
    }
    public function vistaDespensa(Despensa $despensa)
    {
         $user = Auth::user();
         $almacenaje = DB::select(
             'SELECT a.cod_almacenaje,p.cod_producto,p.producto,a.cantidad,u.unidad,a.fec_almac,
             p.comprar,p.favorito,a.cod_despensa 
             FROM `almacenajes` a
             LEFT OUTER JOIN productos p ON p.cod_producto = a.cod_producto
             LEFT OUTER JOIN units u on u.cod_unidad = a.cod_unidad
            where a.cod_despensa = '.$despensa->cod_despensa.' AND a.cod_usuario = '.$user->id
         );
        return $almacenaje;

    }
}
