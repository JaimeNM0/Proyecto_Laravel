<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $params = $request->validate([
            'user' => 'required',
            'password' => 'required',
            //'name' => 'required_without:email',
            //'email' => 'required_without:name',
        ]);

        if (Auth::guard('api')->check()) {
            return $this->enviarResultado(true, 'El usuario ya se ha logueado.', [], 200);
        }

        if (Auth::attempt(['name' => $params['user'],'password' => $params['password']]) || Auth::attempt(['email' => $params['user'],'password' => $params['password']])) {
            $user = Auth::user();
            $token = $user->createToken('tokenJWT')->accessToken;
            return $this->enviarResultado(true, 'El user se ha logueado.', $token);
        }

        return $this->enviarResultado(false, 'El user no se ha encontrado.', [], 401);
    }

    public function logueado(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            return $this->enviarResultado(true, 'El user está logueado.', $user);
        }

        return $this->enviarResultado(false, 'El user no está logueado.', [], 401);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $tokens = $user->tokens;
            foreach ($tokens as $token) {
                $token->delete();
            }
            return $this->enviarResultado(true, 'El user se ha deslogueado.', []);
        }

        return $this->enviarResultado(false, 'El user no se ha encontrado.', [], 401);
    }
}
