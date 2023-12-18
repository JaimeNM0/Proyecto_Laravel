<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $alumnos = Alumno::all();

            return response([
                'success' => true,
                'message' => 'Todos los alumnos se han enviado.',
                'data' => $alumnos
            ]);
        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => 'El alumno no se ha encontrado.',
                'data' => $e
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->validate([
            'nombre' => 'required',
            'password' => 'required',
            'email' => 'required | unique:alumnos,email',
            'sexo' => 'required',
        ]);

        $params['created_at'] = now();

        try {
            $alumno = DB::table('alumnos')->insert($params);

            return response([
                'success' => true,
                'message' => 'El alumno se ha creado correctamente.',
                'data' => $alumno
            ]);
        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => 'El alumno no se ha creado.',
                'data' => $e
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $alumno = Alumno::find($id);

            if ($alumno == null) {
                return response([
                    'success' => false,
                    'message' => 'El alumno no se ha encontrado.',
                    'data' => []
                ]);
            }
            return response([
                'success' => true,
                'message' => 'El alumno se ha encontrado.',
                'data' => $alumno
            ]);
        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => 'El alumno no se ha encontrado.',
                'data' => $e
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $params = $request->validate([
            'email' => 'unique:alumnos,email',
        ]);

        $params['updated_at'] = now();

        try {
            $alumno = Alumno::find($id);
            $alumno->update($params);

            return response([
                'success' => true,
                'message' => 'El alumno se ha actualizado correctamente.',
                'data' => $alumno
            ]);
        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => 'El alumno no existe.',
                'data' => $e
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $alumno = Alumno::find($id);

            if ($alumno == null) {
                return response([
                    'success' => false,
                    'message' => 'El alumno no se ha encontrado, entonces, puede estar ya borrado.',
                    'data' => []
                ]);
            }

            $alumno->delete();

            return response([
                'success' => true,
                'message' => 'El alumno se ha borrado correctamente.',
                'data' => []
            ]);
        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => 'El alumno no se ha borrado.',
                'data' => []
            ]);
        }
    }
}
