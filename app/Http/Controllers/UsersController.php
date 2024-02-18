<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
//use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function registrar(Request $request)
    {
        $params = $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'required | unique:users,email',
        ]);

        $params['created_at'] = now();
        $params['password'] = bcrypt($request->password);

        try {
            DB::table('users')->insert($params);

            return $this->enviarResultado(true, 'El usuario se ha creado correctamente.', []);//$user);
        } catch (Exception $e) {
            return $this->enviarResultado(false, 'El usuario no se ha creado.', []);
        }
    }
}
