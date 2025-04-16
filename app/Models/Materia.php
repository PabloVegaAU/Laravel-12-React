<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $guarded = [];

    // UNA MATERIA TIENE MUCHAS AULAS
    public function aulas()
    {
        return $this->hasMany(AulaDocenteMateria::class, 'materia_id', 'id');
    }

    // UNA MATERIA TIENE MUCHAS CARPETAS
    public function carpetas()
    {
        return $this->hasManyThrough(
            Carpeta::class,
            AulaDocenteMateria::class,
            'materia_id', // Clave foránea en la tabla intermedia (aulas_docentes_materias)
            'aulas_docentes_materias_id', // Clave foránea en la tabla lejana (carpetas)
            'id',         // Clave local en esta tabla (materias)
            'id',          // Clave local en la tabla intermedia (aulas_docentes_materias)
        );
    }

    // LAS MATERIAS A MUCHOS DOCENTES A TRAVES DE AULAS DOCENTES MATERIAS
    public function docentes()
    {
        return $this->belongsToMany(
            Docente::class,
            'aulas_docentes_materias',
            'materia_id',
            'docente_id',
            'id',
            'user_id',
        )->withPivot('aula_id');
    }
}
