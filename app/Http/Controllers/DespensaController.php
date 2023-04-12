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
        //return Despensa::all();
        return Despensa::where('cod_usuario',$user->id)->get();
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

        $despensa = new Despensa;
        $despensa -> despensa = $request-> despensa;
        $despensa -> cod_usuario = $user->id;
        $despensa -> save();

        return $despensa;
    }

    /**
     * Display the specified resource.
     */
    public function show(Despensa $despensa)
    {
        $user = Auth::user();
        
        if($user->id != $despensa->cod_usuario)
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

        if($user->id != $despensa->cod_usuario)
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

        if(is_null($despensa)){
            return response("Error", 404);
        }

        if($user->id != $despensa->cod_usuario)
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
}
