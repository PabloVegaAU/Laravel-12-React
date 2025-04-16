<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $table = 'respuestas';

    protected $guarded = [];

    // UNA RESPUESTA PERTENECE A UN ALUMNO
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    // UNA RESPUESTA PERTENECE A UNA ACTIVIDAD
    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    // UNA RESPUESTA PUEDE TENER UNA IMAGEN
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
