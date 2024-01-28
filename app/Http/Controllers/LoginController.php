<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $params = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($params)) {
            $user = User::where('email', '=', $params['email'])->first();

            if ($user->getRememberToken() != null) {
                return $this->enviarResultado(true, 'El user ya está logueado.', $user);
            }

            $token = $user->createToken('token');
            $user['remember_token'] = $token->accessToken['token'];
            $user->save();

            return $this->enviarResultado(true, 'El user se ha logueado.', []);
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

        if ($user != null) {
            $user['remember_token'] = null;
            $user->save();
            return $this->enviarResultado(true, 'El user se ha deslogueado.', []);
        }

        return $this->enviarResultado(false, 'El user no se ha encontrado.', []);
    }
}
