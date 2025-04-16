<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Logro;
use App\Models\Seccion;
use App\Models\Tarea;
use App\Models\Respuesta;

class Alumno extends Model
{
    protected $primaryKey = 'user_id';
    protected $guarded = [];

    use HasFactory;

    //un alumno pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Muchos alumnos poseen muchos logros
    public function logros()
    {
        return $this->belongsToMany(Logro::class, 'alumno_logro', 'user_id', 'logro_id');
    }

    //Un alumno pertenece a una seccion
    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }

    //Muchos alumnos tienen muchas tareas
    public function tareas()
    {
        return $this->belongsToMany(Tarea::class, 'alumno_tarea', 'user_id', 'tarea_id')->withPivot('nota_final', 'estado', 'hora_inicio', 'hora_final', 'tiempo_transcurrido');
    }

    //un alumno puede tener muchas respuestas
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'user_id');
    }

    //un alumno pertenece a un nivel
    public function level()
    {
        return $this->hasOne(Level::class, 'user_id');
    }
}
