<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorParticular extends Model
{
    use HasFactory;

    public function profesorParticular()
    {
        return $this->hasMany(ProfesorParticular::class);
    }

    public function profesorParticularAlumnos()
    {
        return $this->belongsTo(Alumno::class);
    }
}
