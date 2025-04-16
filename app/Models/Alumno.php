<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $user_id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 */
class Alumno extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'alumnos';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Relación con el modelo User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtiene el perfil del alumno.
     */
    public function perfil(): BelongsTo
    {
        return $this->belongsTo(Perfil::class, 'user_id', 'user_id');
    }

    /**
     * Obtiene los logros del alumno.
     */
    public function logros(): BelongsToMany
    {
        return $this->belongsToMany(Logro::class, 'alumnos_logros', 'alumno_id', 'logro_id')
            ->withTimestamps()
            ->using(AlumnoLogro::class);
    }

    /**
     * Obtiene el aula actual del alumno.
     */
    public function aulaActual()
    {
        return $this->hasOne(AulaAlumno::class, 'alumno_id')
            ->where('es_actual', true)
            ->with('aula');
    }

    /**
     * Obtiene todas las aulas del alumno.
     */
    public function aulas()
    {
        return $this->hasMany(AulaAlumno::class, 'alumno_id')
            ->with('aula');
    }

    /**
     * Obtiene las respuestas del alumno a las trivias.
     */
    public function respuestasTrivia(): HasMany
    {
        return $this->hasMany(TriviaRespuesta::class, 'alumno_id', 'user_id');
    }

    /**
     * Obtiene el nivel del alumno.
     */
    public function nivel(): HasOne
    {
        return $this->hasOne(Nivel::class, 'alumno_id', 'user_id');
    }

    // MUCHOS ALUMNOS TIENEN MUCHAS TAREAS
    public function tareas()
    {
        return $this->belongsToMany(Tarea::class, 'alumnos_tareas', 'alumno_id', 'tarea_id')
            ->withPivot('nota_final', 'estado', 'hora_inicio', 'hora_final', 'tiempo_transcurrido')
            ->withTimestamps();
    }

    // UN ALUMNO PUEDE TENER MUCHAS RESPUESTAS
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'alumno_id');
    }

    // UN ALUMNO PERTENECE A UN NIVEL
    public function level()
    {
        return $this->hasOne(Nivel::class, 'alumno_id');
    }
}
