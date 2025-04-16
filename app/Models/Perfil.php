<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles';

    protected $guarded = [];

    // UN PERFIL PERTENECE A UN USUARIO
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
