<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Lista_Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ListaCompraController;

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
        $producto -> comprar = 0;
        $producto -> favorito = 0;
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
           // 'cod_usuario' => 'required'
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
            $producto -> comprar = $request-> comprar;
            $producto -> favorito = $request-> favorito;
            $producto -> cod_usuario = $user->id;
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
    public static function inicializar($id){
        $productos = ["Leche","Pollo","Ternera","Jamón","Chorizo","Salchichón","Mortadela","Café",
        "Galletas","Yogures","Pan de molde","Azúcar","Harina","Pan rallado","Ajos","Lentejas",
        "Garbanzos","Judías","Langostinos","Gambas","Almejas","Calamares","Huevos","Patatas",
        "Cebollas","Pimiento verde","Pimiento rojo","Calabacines","Berenjenas","Lechuga","Pepinos"];

         foreach ($productos as $item){
             $producto = Producto::create([
                 'producto' => $item,
                 'cod_usuario' => $id,
                 'comprar' => 0,
                 'favorito' => 0,
                 'idioma' => "SPA"
             ]);
         }
    }

    public function upComprar(Request $request, Producto $producto){
        $user = Auth::user();
        //$lista_curso = new Lista_Compra;
        $lista_curso = ListaCompraController::getEnCurso();
        
        if ($request->comprar === 0){
              $producto -> producto = $request-> producto;
              $producto -> comprar = 1;
              $producto -> favorito = $request-> favorito;
              $producto -> idioma = $request-> idioma;
              $producto -> cod_usuario = $user->id;
              $producto -> update();

              DB::table('lista_compra_lins')->insert(
                [
                    'cod_lista' => $lista_curso,
                    'cod_usuario' => $user->id,
                    'cod_producto' => $producto->cod_producto,
                    'nombre' => '',
                    'estado_producto' => 'En curso'
                ]
                
            );
            //   $compra = DB::statement(
            //       'INSERT INTO lista_compra_lins (cod_lista,cod_usuario,cod_producto,nombre,estado_producto)
            //       VALUES ('.$lista_curso.','.$user->id.','.$producto->cod_producto.',"","En curso")'
            //   );
          }else{
              $producto -> producto = $request-> producto;
              $producto -> comprar = 0;
              $producto -> favorito = $request-> favorito;
              $producto -> idioma = $request-> idioma;
              $producto -> cod_usuario = $user->id;
              $producto -> update();

              DB::table('lista_compra_lins')->where([
                ['cod_lista','=',$lista_curso],
                ['cod_producto','=',$producto->cod_producto],
                ['cod_usuario','=',$user->id]
              ])->delete();
            //   $compra = DB::statement(
            //       'DELETE FROM lista_compra_lins WHERE
            //       cod_lista = '.$lista_curso.' AND cod_producto = '.$producto->cod_producto.
            //       ' AND cod_usuario = '.$user->id
            //   );
          }
    }
}