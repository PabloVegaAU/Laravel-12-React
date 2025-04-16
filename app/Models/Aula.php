<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $table = 'aulas';

    protected $guarded = [];

    // UN AULA TIENE MUCHOS ALUMNOS
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'aulas_alumnos', 'aula_id', 'alumno_id')
            ->withPivot('es_actual', 'estado')
            ->withTimestamps();
    }

    // UN AULA TIENE MUCHOS DOCENTES MATERIAS
    public function docentesMaterias()
    {
        return $this->hasMany(AulaDocenteMateria::class);
    }
}
