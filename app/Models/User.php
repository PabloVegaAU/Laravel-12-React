<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $avatar
 * @property string|null $remember_token
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Obtiene el perfil asociado al usuario.
     */
    public function perfil(): HasOne
    {
        return $this->hasOne(Perfil::class, 'user_id');
    }

    /**
     * Obtiene el registro de alumno asociado al usuario.
     */
    public function alumno(): HasOne
    {
        return $this->hasOne(Alumno::class, 'user_id');
    }

    /**
     * Obtiene el registro de docente asociado al usuario.
     */
    public function docente(): HasOne
    {
        return $this->hasOne(Docente::class, 'user_id');
    }

    /**
     * Verifica si el usuario es un alumno.
     */
    public function esAlumno(): bool
    {
        return $this->alumno !== null;
    }

    /**
     * Verifica si el usuario es un docente.
     */
    public function esDocente(): bool
    {
        return $this->docente !== null;
    }
}
