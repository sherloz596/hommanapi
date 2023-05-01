<?php

namespace App\Http\Controllers;

use App\Models\Lista_compra_lin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ListaCompraLinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $listas_compra = DB::table('lista_compra_lins')->get();

        // return $listas_compra;
        $user = Auth::user();
        return Lista_compra_lin::where('cod_usuario',$user->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            //'cod_usuario' => 'required',
            'cod_lista' => 'required',
            'cod_producto' => 'required'
            //'nombre'    => 'required'
        ]);

        $user = Auth::user();

        $lista_compra_lin = new Lista_compra_lin;
        $lista_compra_lin -> cod_lista = $request->cod_lista;
        $lista_compra_lin -> cod_usuario = $user->id;
        $lista_compra_lin -> cod_producto = $request-> cod_producto;
        $lista_compra_lin -> nombre = $request-> nombre;
        $lista_compra_lin -> estado_producto = $request-> estado_producto;
        $lista_compra_lin -> save();

        return $lista_compra_lin;
    }

    /**
     * Display the specified resource.
     */
    public function show(Lista_compra_lin $lista_compra_lin)
    {
        $user = Auth::user();
        
        if($user->id != $lista_compra_lin->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            return $lista_compra_lin;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lista_compra_lin $lista_compra_lin)
    {
        $request -> validate([
            //'cod_usuario' => 'required',
            //'cod_lista' => 'required',
            //'cod_producto' => 'required'
            //'nombre'    => 'required'
        ]);

        $user = Auth::user();

        if($user->id != $lista_compra_lin->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $lista_compra_lin -> cod_lista = $request-> cod_lista;
            $lista_compra_lin -> cod_producto = $request-> cod_producto;
            $lista_compra_lin -> cod_usuario = $user->id;
            //$lista_compra_lin -> nombre = $request-> nombre;
            $lista_compra_lin -> estado_producto = $request-> estado_producto;

            $lista_compra_lin -> update();

             return $lista_compra_lin;

            // DB::table('lista_compra_lins')
            // -> where ('cod_linea',$lista_compra_lin.cod_linea)
            // -> update([
            // 'cod_linea' => $lista_compra_lin.cod_linea,
            // 'cod_lista' => $request-> cod_lista,
            // 'cod_producto' => $request-> cod_producto,
            // 'cod_usuario' => $user->id,
            // 'nombre' => $request-> nombre,
            // 'estado_producto' => $request-> estado,
            // ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lista_compra_lin $lista_compra_lin)
    {
        $lista_compra_lin = Lista_compra_lin::find($id);

        $user = Auth::user();

        if(is_null($lista_compra_lin)){
            return response("Error", 404);
        }

        if($user->id != $lista_compra_lin->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $lista_compra_lin -> delete();

            return response()->noContent();
        }
    }
    public function verCompra(){
        $user = Auth::user();

        $lista = DB::table('lista_compra_lins')
            -> leftJoin('productos','lista_compra_lins.cod_producto','=','productos.cod_producto')
            -> leftJoin('lista_compras','lista_compra_lins.cod_lista','=','lista_compras.cod_lista')
            -> select('lista_compra_lins.cod_linea','lista_compra_lins.cod_lista','productos.cod_producto','productos.producto','lista_compra_lins.estado_producto')
            -> get();
        
        return $lista;
    }
    
    public function upEstado(Request $request, Lista_compra_lin $lista_compra_lin){
        $user = Auth::user();

        DB::statement(
            'UPDATE lista_compra_lins SET estado_producto = '.$request->estado_producto.
            ' WHERE cod_linea = '.$lista_compra_lin->cod_linea);
    }
}
