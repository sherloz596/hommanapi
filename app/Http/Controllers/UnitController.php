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
        //return Unit::all();
        return Unit::where('cod_usuario',$user->id)->get();
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

        $unit = new Unit;
        $unit -> unidad = $request-> unidad;
        $unit -> abreviatura = $request-> abreviatura;
        $unit -> cod_usuario = $user->id;
        $unit -> save();

        return $unit;
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        $user = Auth::user();
        if($user->id != $unit->cod_usuario)
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
        if($user->id != $unit->cod_usuario)
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

        if(is_null($unit)){
            return response("Error", 404);
        }

        if($user->id != $unit->cod_usuario)
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
}
