<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Profesor;
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

            return $this->enviarResultado(true, 'Todos los alumnos se han enviado.', $alumnos);
        } catch (Exception $e) {
            return $this->enviarResultado(false, 'El alumno no se ha encontrado.', []);
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
            'edad' => 'nullable',
            'telefono' => 'nullable',
        ]);

        $params['created_at'] = now();

        try {
            DB::table('alumnos')->insert($params);
            $alumno = Alumno::latest()->first();

            return $this->enviarResultado(true, 'El alumno se ha creado correctamente.', $alumno);
        } catch (Exception $e) {
            return $this->enviarResultado(false, 'El alumno no se ha creado.', []);
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
                return $this->enviarResultado(false, 'El alumno no se ha encontrado.', []);
            }

            return $this->enviarResultado(true, 'El alumno se ha encontrado.', $alumno);
        } catch (Exception $e) {
            return $this->enviarResultado(false, 'El alumno no se ha encontrado.', []);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $params = $request->validate([
            'nombre' => 'nullable',
            'password' => 'nullable',
            'email' => 'unique:alumnos,email',
            'sexo' => 'nullable',
            'edad' => 'nullable',
            'telefono' => 'nullable',
        ]);

        try {
            $alumno = Alumno::find($id);

            if ($alumno == null) {
                return $this->enviarResultado(false, 'El alumno no se ha encontrado.', []);
            }

            if (!empty($params['nombre'])) {
                $alumno->nombre = $params['nombre'];
            }

            if (!empty($params['password'])) {
                $alumno->password = $params['password'];
            }

            if (!empty($params['email'])) {
                $alumno->email = $params['email'];
            }

            if (!empty($params['sexo'])) {
                $alumno->sexo = $params['sexo'];
            }

            if (!empty($params['edad'])) {
                $alumno->edad = $params['edad'];
            }

            if (!empty($params['telefono'])) {
                $alumno->telefono = $params['telefono'];
            }

            $alumno->update();

            return $this->enviarResultado(true, 'El alumno se ha actualizado correctamente.', $alumno);
        } catch (Exception $e) {
            return $this->enviarResultado(false, 'El alumno no se ha actualizado.', []);
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
                return $this->enviarResultado(false, 'El alumno no se ha encontrado, entonces, puede estar ya borrado.', []);
            }

            $alumno->delete();

            return $this->enviarResultado(true, 'El alumno se ha borrado correctamente.', []);
        } catch (Exception $e) {
            return $this->enviarResultado(false, 'El alumno no se ha borrado.', []);
        }
    }

    public function getProfesor($id)
    {
        try {
            /*$alumno = Alumno::find($id);

            if ($alumno->profesor_id == null) {
                return $this->enviarResultado(false, 'El alumno no tiene profesor.', []);
            }

            $profesor = Profesor::find($alumno->profesor_id);

            return $this->enviarResultado(true, 'Profesor obtenido correctamente.', $profesor);*/
            return $this->enviarResultado(true, 'Profesor obtenido correctamente.', data: Alumno::find($id)->profesor);
        } catch (Exception $e) {
            return $this->enviarResultado(false, 'El alumno no se ha encontrado.', []);
        }
    }

    public function getAlumnoEjercicios($id)
    {
        try {
            return $this->enviarResultado(true, 'Ejercicios obtenidos correctamente.', data: Alumno::find($id)->ejercicios);
        } catch (Exception $e) {
            return $this->enviarResultado(false, 'El alumno no se ha encontrado.', []);
        }
    }

    public function enviarResultado(bool $success, string $message, mixed $data, $status = 200)
    {
        return response([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
