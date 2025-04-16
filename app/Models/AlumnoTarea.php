<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoTarea extends Model
{
    use HasFactory;

    protected $table = 'alumnos_tareas';

    protected $guarded = [];

    // UN REGISTRO PERTENECE A UN ALUMNO
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    // UN REGISTRO PERTENECE A UNA TAREA
    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }
}
