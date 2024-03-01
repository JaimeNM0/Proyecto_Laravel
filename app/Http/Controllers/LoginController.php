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
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('api')->check()) {
            return $this->enviarResultado(true, 'El usuario ya esta logueado.', []);
        }

        if (!Auth::attempt($params)) {
            return $this->enviarResultado(false, 'El user no se ha encontrado.', [], 401);
        }

        $token = Auth::user()->createToken('token')->plainTextToken;
        return $this->enviarResultado(true, 'El user se ha logueado.', $token);
    }

    public function logueado(Request $request)
    {
        return $this->enviarResultado(true, 'El user está logueado.', Auth::guard('api')->user());
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();
        $tokens = $user->tokens;
        foreach ($tokens as $token) {
            $token->delete();
        }
        return $this->enviarResultado(true, 'El user se ha deslogueado.', []);
    }
}
