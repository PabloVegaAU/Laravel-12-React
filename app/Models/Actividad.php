<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $guarded = [];

    // UNA ACTIVIDAD TIENE MUCHAS RESPUESTAS
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }

    // UNA ACTIVIDAD PERTENECE A UNA SOLA TAREA
    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    // UNA ACTIVIDAD PUEDE TENER UNA IMAGEN (RELACIÓN POLIMÓRFICA)
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
