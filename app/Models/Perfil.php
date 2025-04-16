<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Perfil extends Model
{
    use HasFactory;
    protected $guarded = [];

    //un perfil pertenece a un usuario

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
