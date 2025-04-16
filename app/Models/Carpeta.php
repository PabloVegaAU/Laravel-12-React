<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carpeta extends Model
{
    use HasFactory;

    protected $table = 'carpetas';

    protected $guarded = [];

    // UNA CARPETA POSEE MUCHAS TAREAS EN SU INTERIOR
    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }

    // UNA CARPETA PERTENECE A UN AULA-DOCENTE-MATERIA
    public function aulaDocenteMateria()
    {
        return $this->belongsTo(AulaDocenteMateria::class, 'aulas_docentes_materias_id');
    }
}
