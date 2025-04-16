<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';

    protected $guarded = [];

    // UNA TAREA PERTENECE A MUCHOS ALUMNOS
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumnos_tareas', 'tarea_id', 'alumno_id')->withPivot('nota_final', 'estado', 'hora_inicio', 'hora_final', 'tiempo_transcurrido');
    }

    // UNA TAREA POSEE MUCHAS ACTIVIDADES
    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }

    // UNA TAREA PERTENECE A UNA SOLA CARPETA
    public function carpeta()
    {
        return $this->belongsTo(Carpeta::class);
    }
}
