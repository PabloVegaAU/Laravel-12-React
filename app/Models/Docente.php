<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';

    protected $primaryKey = 'user_id';

    protected $guarded = [];

    // UN DOCENTE PERTENECE A UN USUARIO
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // UN DOCENTE TIENE MUCHAS AULA MATERIAS
    public function aulaMaterias()
    {
        return $this->hasMany(AulaDocenteMateria::class, 'docente_id', 'user_id');
    }

    // UN DOCENTE TIENE MUCHAS AULAS A TRAVÉS DE AULADOCENTEMATERIA
    public function aulas()
    {
        return $this->belongsToMany(Aula::class, 'aulas_docentes_materias', 'docente_id', 'aula_id', 'user_id');
    }

    // UN DOCENTE TIENE MUCHAS MATERIAS A TRAVÉS DE AULADOCENTEMATERIA
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'aulas_docentes_materias', 'docente_id', 'materia_id', 'user_id');
    }

    // UN DOCENTE TIENE MUCHAS CARPETAS A TRAVÉS DE AULADOCENTEMATERIA
    public function carpetas()
    {
        return $this->hasManyThrough(
            Carpeta::class,
            AulaDocenteMateria::class,
            'docente_id', // Clave foránea en la tabla intermedia (aulas_docentes_materias)
            'aulas_docentes_materias_id', // Clave foránea en la tabla lejana (carpetas)
            'user_id',    // Clave local en esta tabla (docentes)
            'id',          // Clave local en la tabla intermedia (aulas_docentes_materias)
        );
    }
}
