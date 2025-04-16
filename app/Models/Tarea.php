<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Alumno;
use App\Models\Actividad;
use App\Models\Carpeta;
use App\Models\Image;

class Tarea extends Model
{
    protected $guarded = [];

    use HasFactory;

    //Muchas tareas son asignadas a muchos alumnos
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_tarea', 'tarea_id', 'user_id')->withPivot('nota_final', 'estado', 'hora_inicio', 'hora_final', 'tiempo_transcurrido');
    }

    //UNA TAREA POSEE MUCHAS ACTIVIDADES
    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }

    //UNA TAREA PERTENECE A UNA SOLA CARPETA
    public function carpeta()
    {
        return $this->belongsTo(Carpeta::class);
    }
}
