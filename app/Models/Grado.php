<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seccion;

class Grado extends Model
{
    use HasFactory;
    protected $guarded = [];

    //un grado puede aparecer en los registros de muchas secciones
    public function seccions()
    {
        return $this->hasMany(Seccion::class);
    }
}
