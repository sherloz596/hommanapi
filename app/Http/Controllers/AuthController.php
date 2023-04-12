<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\User;
use App\Models\Despensa;
use App\Models\Unit;

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
      $despensa = Despensa::create([
        'despensa' => "Nevera",
        'cod_usuario' => $user->id
      ]);

      $despensa = Despensa::create([
        'despensa' => "Congelador",
        'cod_usuario' => $user->id
      ]);

      $unit = Unit::create([
        'unidad' => "Gramos",
        'abreviatura' => "g",
        'cod_usuario' => $user->id
      ]);

      $unit = Unit::create([
        'unidad' => "Kilos",
        'abreviatura' => "Kg",
        'cod_usuario' => $user->id
      ]);

      $unit = Unit::create([
        'unidad' => "Litros",
        'abreviatura' => "l",
        'cod_usuario' => $user->id
      ]);

      $unit = Unit::create([
        'unidad' => "Latas",
        'abreviatura' => "",
        'cod_usuario' => $user->id
      ]);

      $unit = Unit::create([
        'unidad' => "Botellas",
        'abreviatura' => "",
        'cod_usuario' => $user->id
      ]);

      $unit = Unit::create([
        'unidad' => "Bricks",
        'abreviatura' => "",
        'cod_usuario' => $user->id
      ]);


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
