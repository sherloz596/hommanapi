<?php

namespace App\Http\Controllers;

use App\Models\Lista_compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ListaCompraController extends Controller
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
        //return Lista_compra::all();
        return Lista_compra::where('cod_usuario',$cod_user)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            //'cod_usuario' => 'required',
           // 'cod_producto' => 'required',
           // 'nombre'    => 'required'
        ]);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if($request -> estado === 'En curso'){

        }

        $lista_compra = new Lista_compra;
        $lista_compra -> cod_usuario = $cod_user;
      //  $lista_compra -> cod_producto = $request-> cod_producto;
        $lista_compra -> nombre = $request-> nombre;
        $lista_compra -> estado = $request-> estado;
        $lista_compra -> save();

        return $lista_compra;
    }

    /**
     * Display the specified resource.
     */
    public function show(Lista_compra $lista_compra)
    {
        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }
        
        if($cod_user != $lista_compra->cod_usuario)
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
            //'cod_producto' => 'required',
            //'nombre'    => 'required'
        ]);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if($cod_user != $lista_compra->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
        // $lista_compra -> cod_usuario = $request-> cod_usuario;
        //    $lista_compra -> cod_producto = $request-> cod_producto;
            $lista_compra -> nombre = $request-> nombre;
            $lista_compra -> estado = $request-> estado;

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

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if(is_null($lista_compra)){
            return response("Error", 404);
        }

        if($cod_user != $lista_compra->cod_usuario)
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
    public static function getEnCurso(){
        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        //  $lista = Lista_compra::where('cod_usuario',$user->id)->get();
        //  where('estado',"En curso")->get();

        $lista = DB::table('lista_compras')->where([
            ['cod_usuario','=',$cod_user],
            ['estado','=','En curso']
        ])->first();

        // $lista = new Lista_compra;
        // $lista = DB::select(
        //     'SELECT * FROM lista_compras WHERE estado = "En curso" 
        //     and cod_usuario = '.$user->id
        // );
        // $prueba = $cod_curso->estado;
         return $lista->cod_lista;
    }

    public static function inicializar($id){
        $lista = Lista_compra::create([
            'cod_usuario' => $id,
            'nombre' => "",
            'estado' => "En curso",
        ]);
    }
}
