<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Alumno;
use App\Models\Actividad;

class Respuesta extends Model
{
    use HasFactory;
    protected $guarded = [];
    //una respuesta le pertenece solo a un alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'user_id');
    }

    //UNA RESPUESTA PERTENECE A UNA ACTIVIDAD
    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
