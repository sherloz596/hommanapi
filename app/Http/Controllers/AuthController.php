<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\User;
use App\Models\Despensa;
use App\Models\Unit;
use App\Models\Producto;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DespensaController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ListaCompraController;

class AuthController extends Controller
{
    public function register(Request $request)
    {
      $validator = Validator::make($request->all(),[
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8'
      ]);
      
      if($validator->fails()){
        return response()->json($validator->errors());
      }

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
      ]);

# INTRODUCCIÓN DE DATOS DE DESPENSAS Y UNIDADES POR DEFECTO


      DespensaController::inicializar($user->id);
      UnitController::inicializar($user->id);
      ProductoController::inicializar($user->id);
      ListaCompraController::inicializar($user->id);


      $token = $user->createToken('auth_token')->plainTextToken;

      return response()
        ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email','password')))
        {
            return response()
                ->json(['message'=> 'No autorizado'],401);
        }

        $user = User::where('email',$request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'message' => 'Hi '.$user->name,
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Te has deslogueado correctamente'
        ];
    }
}
