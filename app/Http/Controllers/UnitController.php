<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
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
        //return Unit::all();
        return Unit::where('cod_usuario',$cod_user)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'unidad'    => 'required',
            //'cod_usuario' => 'required'
        ]);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        $unit = new Unit;
        $unit -> unidad = $request-> unidad;
        $unit -> abreviatura = $request-> abreviatura;
        $unit -> cod_usuario = $cod_user;
        $unit -> save();

        return $unit;
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if($cod_user != $unit->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            return $unit;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $request -> validate([
            'unidad'    => 'required',
            //'cod_usuario' => 'required'
        ]);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if($cod_user != $unit->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $unit -> unidad = $request-> unidad;
            $unit -> abreviatura = $request-> abreviatura;
            //$unit -> cod_usuario = $request-> cod_usuario;
            $unit -> update();

            return $unit;
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unit = unit::find($id);

        $user = Auth::user();

        if ($user->invitado === null)
        {
            $cod_user = $user->id;
        }else{
            $cod_user = $user->invitado;
        }

        if(is_null($unit)){
            return response("Error", 404);
        }

        if($cod_user != $unit->cod_usuario)
        {
            return [
                'message' => 'Error: usuario no válido'
            ];
        }else
        {
            $unit -> delete();

            return response()->noContent();
        }
    }
    public static function inicializar($id){
        $units = ["Gramos","Kilos","Litros","Latas","Botellas","Bricks","Unidades","Filetes"];

        foreach ($units as $item){
            $unit = Unit::create([
                'unidad' => $item,
                'abreviatura' => "",
                'cod_usuario' => $id,
                'idioma' => "SPA"
            ]);
        }
    }
}