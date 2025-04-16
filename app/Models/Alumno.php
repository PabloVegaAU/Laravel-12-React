<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $primaryKey = 'user_id';

    protected $guarded = [];

    // UN ALUMNO PERTENECE A UN USUARIO
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // MUCHOS ALUMNOS POSEEN MUCHOS LOGROS
    public function logros()
    {
        return $this->belongsToMany(Logro::class, 'alumnos_logros', 'alumno_id', 'logro_id');
    }

    // SI UN ALUMNO TIENE UN AULA ACTUAL
    public function aulaActual()
    {
        return $this->belongsToMany(Aula::class, 'aulas_alumnos', 'alumno_id', 'aula_id')
            ->withPivot('es_actual', 'estado')
            ->wherePivot('es_actual', true)
            ->first();
    }

    // MUCHOS ALUMNOS PERTENECEN A MUCHAS AULAS
    public function aulas()
    {
        return $this->belongsToMany(Aula::class, 'aulas_alumnos', 'alumno_id', 'aula_id')
            ->withPivot('es_actual', 'estado')
            ->withTimestamps();
    }

    // MUCHOS ALUMNOS TIENEN MUCHAS TAREAS
    public function tareas()
    {
        return $this->belongsToMany(Tarea::class, 'alumnos_tareas', 'alumno_id', 'tarea_id')
            ->withPivot('nota_final', 'estado', 'hora_inicio', 'hora_final', 'tiempo_transcurrido')
            ->withTimestamps();
    }

    // UN ALUMNO PUEDE TENER MUCHAS RESPUESTAS
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'alumno_id');
    }

    // UN ALUMNO PERTENECE A UN NIVEL
    public function level()
    {
        return $this->hasOne(Level::class, 'alumno_id');
    }
}
