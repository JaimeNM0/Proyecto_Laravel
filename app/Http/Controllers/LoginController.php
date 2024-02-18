<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if(isset($params['name']) && isset($params['email'])){
            return $this->enviarResultado(false, 'Solo puedes introducir uno de los dos campos name o email.', [], 400);
        }

        if (Auth::attempt($params)) {
            if (Auth::user()->tokens->isNotEmpty()) {
                return $this->enviarResultado(true, 'El usuario ya esta logueado.', Auth::user()->tokens);
            }
            $token = Auth::user()->createToken('token');
            return $this->enviarResultado(true, 'El user se ha logueado.', $token->accessToken->token);
        }

        return $this->enviarResultado(false, 'El user no se ha encontrado.', []);
    }

    public function logueado(Request $request)
    {
        $params = $request->validate([
            'remember_token' => 'required'
        ]);

        $user = User::where('remember_token', '=', $params['remember_token'])->first();

        if ($user != null) {
            return $this->enviarResultado(true, 'El user está logueado.', $user);
        }

        return $this->enviarResultado(false, 'El user no está logueado.', []);
    }

    public function logout(Request $request)
    {
        $params = $request->validate([
            'remember_token' => 'required'
        ]);

        $user = User::where('remember_token', '=', $params['remember_token'])->first();

        $tokens = $user->tokens;
        foreach ($tokens as $token) {
            $token->delete();
        }

        if ($user != null) {
            $user->remember_token = null;
            $user->save();
            return $this->enviarResultado(true, 'El user se ha deslogueado.', []);
        }

        return $this->enviarResultado(false, 'El user no se ha encontrado.', []);
    }
}
