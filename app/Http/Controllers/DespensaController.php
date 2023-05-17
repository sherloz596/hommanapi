<?php

namespace App\Http\Controllers;

use App\Models\Despensa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DespensaController extends Controller
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
        //return Despensa::all();
        return Despensa::where('cod_usuario',$cod_user)
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'despensa'    => 'required',
            //'cod_usuario' => 'required'
        ]);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        $despensa = new Despensa;
        $despensa -> despensa = $request-> despensa;
        $despensa -> cod_usuario = $cod_user;
        $despensa -> idioma = $request-> idioma;
        $despensa -> save();

        return $despensa;
    }

    /**
     * Display the specified resource.
     */
    public function show(Despensa $despensa)
    {
        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }
        
        if($cod_user != $despensa->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            return $despensa;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Despensa $despensa)
    {
        $request -> validate([
            'despensa'    => 'required',
            //'cod_usuario' => 'required'
        ]);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if($cod_user != $despensa->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $despensa -> despensa = $request-> despensa;
            //$despensa -> cod_usuario = $request-> cod_usuario;
            $despensa -> update();

            return $despensa;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $despensa = Despensa::find($id);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if(is_null($despensa)){
            return response("Error", 404);
        }

        if($cod_user != $despensa->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $despensa -> delete();

            return response()->noContent();
        }
    }
    public static function inicializar($id){
        $json = '[
            {
                "despensa" :"Nevera",
                "idioma"   : "Fridge"
            },
            {
                "despensa" :"Congelador",
                "idioma"   : "Freezer"
            },
            {
                "despensa" :"Armario",
                "idioma"   : "Pantry"
            }
        ]';

        $despensas = json_decode($json);
        // $despensas[] = array (
        //         'despensa' => 'Nevera',
        //         'idioma'   => 'Fridge');
            
        //    array_push($despensas,array (
        //         'despensa' => 'Congelador',
        //         'idioma'   => 'Freezer'
        //    ));
                
        //    array_push($despensas,array (
        //         'despensa' => 'Armario',
        //         'idioma'   => 'Pantry'
        //     ));

        // $desp_eng = ["Fridge","Freezer","Pantry"];

        foreach ($despensas as $item){
            $despensa = Despensa::create([
                'despensa' => $item->despensa,
                'cod_usuario' => $id,
                'idioma' => $item->idioma
            ]);
        };

        // foreach ($desp_eng as $item){
        //     $despensa = Despensa::create([
        //         'despensa' => $item,
        //         'cod_usuario' => $id,
        //         'idioma' => "ENG"
        //     ]);
        // }
    }
}
