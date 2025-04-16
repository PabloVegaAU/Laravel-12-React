<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{
    use HasFactory;

    protected $table = 'logros';

    protected $guarded = [];

    // UN LOGRO PERTENECE A MUCHOS ALUMNOS
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumnos_logros', 'logro_id', 'alumno_id');
    }

    // UN LOGRO TIENE UNA IMAGEN
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
