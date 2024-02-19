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
            'name' => 'required_without:email',
            'password' => 'required',
            'email' => 'required_without:name',
        ]);

        if (isset($params['name']) && isset($params['email'])) {
            return $this->enviarResultado(false, 'Solo puedes introducir uno de los dos campos name o email.', [], 400);
        }

        if (!Auth::attempt($params)) {
            return $this->enviarResultado(false, 'El user no se ha encontrado.', []);
        }

        if (Auth::user()->tokens->isNotEmpty()) {
            return $this->enviarResultado(true, 'El usuario ya esta logueado.', []);
        }

        $token = Auth::user()->createToken('token')->plainTextToken;
        return $this->enviarResultado(true, 'El user se ha logueado.', $token);//->accessToken->token);
    }

    public function logueado(Request $request)
    {
        if (Auth::user() != null) {
            return $this->enviarResultado(true, 'El user está logueado.', Auth::user());
        }

        return $this->enviarResultado(false, 'El user no está logueado.', []);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user != null) {
            $tokens = $user->tokens;
            foreach ($tokens as $token) {
                $token->delete();
            }
            return $this->enviarResultado(true, 'El user se ha deslogueado.', []);
        }

        return $this->enviarResultado(false, 'El user no se ha encontrado.', []);
    }
}
