<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Docente;
use App\Models\Carpeta;

class Materia extends Model
{
    use HasFactory;

    protected $guarded = [];
    //LAS MATERIAS SON REPARTIDAS A MUCHOS DOCENTES
    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'docente_materia', 'materia_id', 'user_id');
    }

    //LAS MATERIAS APARECEN EN MUCHOS REGISTROS DE LAS CARPETAS
    public function carpetas()
    {
        return $this->hasMany(Carpeta::class);
    }
}
