<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaAlumno extends Model
{
    use HasFactory;

    protected $table = 'aulas_alumnos';

    protected $guarded = [];

    // UN REGISTRO PERTENECE A UN AULA
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    // UN REGISTRO PERTENECE A UN ALUMNO
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }
}
