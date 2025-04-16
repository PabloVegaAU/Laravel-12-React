<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perfil extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'perfiles';

    protected $primaryKey = 'user_id';

    protected $guarded = [];

    // UN PERFIL PERTENECE A UN USUARIO
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
