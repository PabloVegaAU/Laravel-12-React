<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaDocenteMateria extends Model
{
    use HasFactory;

    protected $table = 'aulas_docentes_materias';

    protected $guarded = [];

    // UN REGISTRO PERTENECE A UN AULA
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    // UN REGISTRO PERTENECE A UN DOCENTE
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    // UN REGISTRO PERTENECE A UNA MATERIA
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
