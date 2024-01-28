<?php

use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\AsignaturasController;
use App\Http\Controllers\EjerciciosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfesorsController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VerifyId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//TODO route del login
Route::post('login', [LoginController::class, 'login']);
Route::post('logueado', [LoginController::class, 'logueado']);
Route::post('logout', [LoginController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(VerifyId::class)->apiResource('alumnos', AlumnosController::class);

Route::get('alumnos/{id}/profesor', [AlumnosController::class, 'getProfesor']);
Route::get('profesor/{id}/alumnos', [ProfesorsController::class, 'getProfesorAlumnos']);

Route::get('ejercicios/{id}/alumno', [EjerciciosController::class, 'getAlumno']);
Route::get('alumno/{id}/ejercicios', [AlumnosController::class, 'getAlumnoEjercicios']);

Route::get('ejercicios/{id}/asignatura', [EjerciciosController::class, 'getAsignatura']);
Route::get('asignatura/{id}/ejercicios', [AsignaturasController::class, 'getAsignaturaEjercicios']);
