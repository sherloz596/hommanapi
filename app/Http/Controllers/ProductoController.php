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

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if ($user -> idioma === 'SPA'){
            $orden = 'producto';
        }else{
            $orden = 'idioma';
        }
        return Producto::where('cod_usuario',$cod_user)
        ->orderBy($orden)
        ->get();
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

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        $producto = new Producto;
        $producto -> producto = $request-> producto;
        $producto -> cod_usuario = $cod_user;
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
        
        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }
        
        if($cod_user != $producto->cod_usuario)
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

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if($cod_user != $producto->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $producto -> producto = $request-> producto;
            $producto -> comprar = $request-> comprar;
            $producto -> favorito = $request-> favorito;
            $producto -> cod_usuario = $cod_user;
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

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if(is_null($producto)){
            return response("Error", 404);
        }

        if($cod_user != $producto->cod_usuario)
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
        $json = '[
            {
                "producto" :"Leche",
                "idioma"   : "Milk"
            },
            {
                "producto" :"Pollo",
                "idioma"   : "Chicken"
            },
            {
                "producto" :"Ternera",
                "idioma"   : "Beef"
            },
            {
                "producto" :"Jamón",
                "idioma"   : "Ham"
            }, 
            {
                "producto" :"Chorizo",
                "idioma"   : "Sausage"
            },
            {
                "producto" :"Salchichón",
                "idioma"   : "Salami"
            },            
            {
                "producto" :"Café",
                "idioma"   : "Coffee"
            },
            {
                "producto" :"Galletas",
                "idioma"   : "Cookies"
            },            
            {
                "producto" :"Yogures",
                "idioma"   : "Yogurts"
            },
            {
                "producto" :"Pan de molde",
                "idioma"   : "Bread"
            },
            {
                "producto" :"Azúcar",
                "idioma"   : "Sugar"
            },            
            {
                "producto" :"Harina",
                "idioma"   : "Flour"
            },
            {
                "producto" :"Pan rallado",
                "idioma"   : "Bread crumbs"
            },
            {
                "producto" :"Ajos",
                "idioma"   : "Garlics"
            },            {
                "producto" :"Lentejas",
                "idioma"   : "Lentils"
            },
            {
                "producto" :"Garbanzos",
                "idioma"   : "Chickpeas"
            },
            {
                "producto" :"Judías",
                "idioma"   : "Beans"
            },            
            {
                "producto" :"Langostinos",
                "idioma"   : "Prawns"
            },
            {
                "producto" :"Gambas",
                "idioma"   : "Shrimps"
            },
            {
                "producto" :"Almejas",
                "idioma"   : "Clams"
            },    
            {
                "producto" :"Calamares",
                "idioma"   : "Squids"
            },
            {
                "producto" :"Huevos",
                "idioma"   : "Eggs"
            },
            {
                "producto" :"Patatas",
                "idioma"   : "Potatoes"
            },
            {
                "producto" :"Cebollas",
                "idioma"   : "Onions"
            },             
            {
                "producto" :"Pimiento verde",
                "idioma"   : "Green pepper"
            },
            {
                "producto" :"Pimiento rojo",
                "idioma"   : "Red pepper"
            },
            {
                "producto" :"Calabacines",
                "idioma"   : "Zucchini"
            },            
            {
                "producto" :"Berenjenas",
                "idioma"   : "Eggplants"
            },
            {
                "producto" :"Lechuga",
                "idioma"   : "Lettuce"
            },
            {
                "producto" :"Pepinos",
                "idioma"   : "Cucumbers"
            }
        ]';

        $productos = json_decode($json);
        // $productos = ["Leche","Pollo","Ternera","Jamón","Chorizo","Salchichón","Mortadela","Café",
        // "Galletas","Yogures","Pan de molde","Azúcar","Harina","Pan rallado","Ajos","Lentejas",
        // "Garbanzos","Judías","Langostinos","Gambas","Almejas","Calamares","Huevos","Patatas",
        // "Cebollas","Pimiento verde","Pimiento rojo","Calabacines","Berenjenas","Lechuga","Pepinos"];

         foreach ($productos as $item){
             $producto = Producto::create([
                 'producto' => $item->producto,
                 'cod_usuario' => $id,
                 'comprar' => 0,
                 'favorito' => 0,
                 'idioma' => $item->idioma
             ]);
         }
    }

    public function upComprar(Request $request, Producto $producto){
        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }
        //$lista_curso = new Lista_Compra;
        $lista_curso = ListaCompraController::getEnCurso();
        
        if ($request->comprar === 0){
              $producto -> producto = $request-> producto;
              $producto -> comprar = 1;
              $producto -> favorito = $request-> favorito;
              $producto -> idioma = $request-> idioma;
              $producto -> cod_usuario = $cod_user;
              $producto -> update();

              DB::table('lista_compra_lins')->insert(
                [
                    'cod_lista' => $lista_curso,
                    'cod_usuario' => $cod_user,
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
              $producto -> cod_usuario = $cod_user;
              $producto -> update();

              DB::table('lista_compra_lins')->where([
                ['cod_lista','=',$lista_curso],
                ['cod_producto','=',$producto->cod_producto],
                ['cod_usuario','=',$cod_user]
              ])->delete();
            //   $compra = DB::statement(
            //       'DELETE FROM lista_compra_lins WHERE
            //       cod_lista = '.$lista_curso.' AND cod_producto = '.$producto->cod_producto.
            //       ' AND cod_usuario = '.$user->id
            //   );
          }
    }
}