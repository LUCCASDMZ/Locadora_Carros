<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credenciais = $request->all();

        //Atenticação (email e senha)
        $token = auth('api')->attempt($credenciais);

        if($token){
            return response()->json(['oken'=>$token]);

        } else {
            return response()->json(['error'=>'Usuario ou senha invalido'], 403);
        }

        //Retornar um JTW
    }
    public function logout()
    {
        return 'logout';
    }
    public function refresh()
    {
        return 'refresh';
    }
    public function me()
    {
        return 'me';
    }
}
