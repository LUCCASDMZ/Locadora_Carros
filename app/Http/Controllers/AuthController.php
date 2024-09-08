<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credenciais = $request->all();

        //Atenticação (email e senha)
        $token = JWTAuth::attempt($credenciais);

        if($token){
            return response()->json(['Token'=>$token]);

        } else {
            return response()->json(['error'=>'Usuario ou senha invalido'], 403);
        }

        //Retornar um JTW
    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        if ($token) {
            JWTAuth::invalidate($token);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Logout realizado com sucesso'
        ]);
    }

    public function refresh(): JsonResponse
    {
        try {
            $oldToken = JWTAuth::getToken();
            if (!$oldToken) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token não fornecido'
                ], 401);
            }

            $token = JWTAuth::refresh($oldToken);

            return response()->json([
                'status' => 'success',
                'token' => $token,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível atualizar o token'
            ], 401);
        }
    }

    public function me()
    {
        return response()->json((auth()->user()));
    }
}
