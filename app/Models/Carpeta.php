<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tarea;
use App\Models\Docente;
use App\Models\Seccion;

class Carpeta extends Model
{
    use HasFactory;

    protected $guarded = [];

    //UNA CARPETA POSEE MUCHAS TAREAS EN SU INTERIOR
    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }

    //una carpeta le pertenece  a un docente
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'user_id');
    }

    //UNA CARPETA LE PERTENECE A UNA MATERIA

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    //UNA CARPETA PERTEENCE A UNA SECCION
    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }
}
