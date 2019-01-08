<?php namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    /**
    * Cadastra um novo usuário na base
    *
    * @return mixed
    */
    public function signup(Request $request)
    {
      $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required'
      ]);

      $user = new User([
        'name'     => $request->input('name'),
        'email'    => $request->input('email'),
        'password' => bcrypt($request->input('password'))
      ]);
      $user->save();
      return response()->json(['error'=>false, 'result'=>'OK', 'operation'=>'user_resgister']);
    }

    /**
    * Cria e retorna im json webtoken assinado
    *
    * @return mixed
    */
    public function signin(Request $request)
    {
      $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required'
      ]);

      $credentials = $request->only('email','password');

      try {
        if(!$token = JWTAuth::attempt($credentials)){
          return response()->json([
            'error' => 'Email ou senha inválidos'
          ], 401);
        }
      } catch (JWTException $e){
        return response()->json([
          'error' => 'Não foi possível criar o token'
        ], 500);
      }

      return response()->json([
        'token' => $token
      ], 200);

    }
}