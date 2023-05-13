<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Models\User;
use App\Models\Despensa;
use App\Models\Unit;
use App\Models\Producto;
use App\Mail\MailPassword;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DespensaController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ListaCompraController;
use Illuminate\Support\Facades\DB;

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
            'message' => 'Logout OK'
        ];
    }

    public function recoveryPass(Request $request)
    {
      $request->validate([
        'email' => 'required|email|exists:users',
      ]);
      // Mail::to('sherloz596@gmail.com')->send(new MailPassword());
      
      $user = User::where('email',$request['email'])->firstOrFail();
      $token = $user->createToken('auth_token')->plainTextToken;

      DB::table('password_reset_tokens')->insert([
        'email' => $request->email,
        'token' => $token,
      ]);

      // Mail::send('email.email', ['token' => $token], function($message) use($request){
      // $message->to($request->email);
      // $message->subject('Cambiar contraseña en CMS Laravel');
      // });
      Mail::to($request->email)->send(new MailPassword($user,$token));
      return[
        'message' => 'Mail enviado'
      ];
    }

    public function resetPassword(Request $request)
    {
      // $mail_reset = DB::table('users')
      // -> select ('email')
      // -> where ('id','=',$request->id)
      // -> get();

      // $token_reset = DB::table('password_reset_tokens')
      // -> select('token')
      // -> where('email','=',$mail_reset)
      // -> get();
      $mail_reset = DB::select(
        'SELECT email from users where id = '.$request->id
      );

      $token_reset = DB::select(
        'SELECT token from password_reset_tokens where email = "'.$mail_reset[0]->email.'"'
      );
      if ($token_reset[0]->token === $request->token){
        User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        
        DB::table('password_reset_tokens')
        -> where ('email','=',$mail_reset[0]->email)
        -> delete();

        return[
          'message' => "Reset ok"
        ] ;
      }else{
        return [
          'message' => "Usuario no válido"
        ];
      }
    }
}
