<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ejercicio;
use Exception;
use Illuminate\Http\Request;

class EjerciciosController extends Controller
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

    public function getAlumno($id)
    {
        try {
            return $this->enviarResultado(true, 'Alumno obtenido correctamente.', data: Ejercicio::find($id)->alumno);
        } catch (Exception $e) {
            return $this->enviarResultado(false, 'El ejercicio no se ha encontrado.', []);
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
