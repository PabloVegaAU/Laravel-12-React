<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seccion;
use App\Models\User;
use App\Models\Materia;
use App\Models\Carpeta;

class Docente extends Model
{
    protected $primaryKey = 'user_id';
    protected $guarded = [];
    use HasFactory;

    //un docente pertenece a un usuario

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    //LOS DOCENTES PERTENECEN A MUCHAS SECCIONES
    public function secciones()
    {
        return $this->belongsToMany(Seccion::class, 'docente_seccion', 'user_id', 'seccion_id');
    }

    //una respuesta le pertenece solo a un alumno
    public function carpetas()
    {
        return $this->hasMany(Carpeta::class, 'user_id');
    }

    //LOS DOCENTES TIENEN MUCHAS MATERIAS
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'docente_materia', 'user_id', 'materia_id');
    }
}
