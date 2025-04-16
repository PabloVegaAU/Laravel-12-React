<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoLogro extends Model
{
    use HasFactory;

    protected $table = 'alumnos_logros';

    protected $guarded = [];

    // UN REGISTRO PERTENECE A UN ALUMNO
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    // UN REGISTRO PERTENECE A UN LOGRO
    public function logro()
    {
        return $this->belongsTo(Logro::class, 'logro_id');
    }
}
