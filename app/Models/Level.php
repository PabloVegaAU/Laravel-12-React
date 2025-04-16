<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';

    protected $guarded = [];

    // UN REGISTRO PERTENECE A UN ALUMNO
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }
}
