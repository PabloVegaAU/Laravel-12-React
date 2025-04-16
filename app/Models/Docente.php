<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $user_id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 */
class Docente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'docentes';

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
     * Obtiene el usuario asociado al docente.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtiene el perfil del docente.
     */
    public function perfil(): BelongsTo
    {
        return $this->belongsTo(Perfil::class, 'user_id', 'user_id');
    }

    /**
     * Obtiene las relaciones de aula-docente-materia del docente.
     */
    public function aulasDocentesMaterias(): HasMany
    {
        return $this->hasMany(AulaDocenteMateria::class, 'docente_id', 'user_id');
    }

    /**
     * Obtiene las aulas donde el docente imparte clases.
     */
    public function aulas(): BelongsToMany
    {
        return $this->belongsToMany(
            Aula::class,
            'aulas_docentes_materias',
            'docente_id',
            'aula_id',
            'user_id',
            'id'
        )->withTimestamps();
    }

    /**
     * Obtiene las materias que el docente imparte.
     */
    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(
            Materia::class,
            'aulas_docentes_materias',
            'docente_id',
            'materia_id',
            'user_id',
            'id'
        )->withTimestamps();
    }

    /**
     * Obtiene las carpetas creadas por el docente.
     */
    public function carpetas(): HasManyThrough
    {
        return $this->hasManyThrough(
            Carpeta::class,
            AulaDocenteMateria::class,
            'docente_id', // Clave foránea en la tabla intermedia (aulas_docentes_materias)
            'aulas_docentes_materias_id', // Clave foránea en la tabla lejana (carpetas)
            'user_id',    // Clave local en esta tabla (docentes)
            'id',          // Clave local en la tabla intermedia (aulas_docentes_materias)
        );
    }
}
