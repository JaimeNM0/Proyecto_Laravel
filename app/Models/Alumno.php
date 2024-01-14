<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $hidden = [
        'password'
    ];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function ejercicios()
    {
        return $this->hasMany(Ejercicio::class);
    }
}
