<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Profesor;
use Exception;
use Illuminate\Http\Request;

class ProfesorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getProfesorAlumnos($id)
    {
        try {
            /*$profesor = Profesor::find($id);

            $alumnos = Alumno::find($profesor->id);

            return $this->enviarResultado(true, 'Alumnos obtenidos correctamente.', $alumnos);*/
            return $this->enviarResultado(true, 'Alumnos obtenidos correctamente.', data: Profesor::find($id)->alumnos);
        } catch (Exception $e) {
            return $this->enviarResultado(false, 'El profesor no se ha encontrado.', []);
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
