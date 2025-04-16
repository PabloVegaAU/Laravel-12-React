<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $aula_id
 * @property int $docente_id
 * @property int $materia_id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 */
class AulaDocenteMateria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'aulas_docentes_materias';

    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'aula_id',
        'docente_id',
        'materia_id',
    ];

    /**
     * Obtiene el aula asociada.
     */
    public function aula(): BelongsTo
    {
        return $this->belongsTo(Aula::class, 'aula_id');
    }

    /**
     * Obtiene el docente asociado.
     */
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class, 'docente_id', 'user_id');
    }

    /**
     * Obtiene la materia asociada.
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    /**
     * Obtiene las carpetas de esta relación aula-docente-materia.
     */
    public function carpetas(): HasMany
    {
        return $this->hasMany(Carpeta::class, 'aulas_docentes_materias_id');
    }

    /**
     * Obtiene las tareas de esta relación aula-docente-materia.
     */
    public function tareas()
    {
        return $this->hasManyThrough(
            Tarea::class,
            Carpeta::class,
            'aulas_docentes_materias_id', // FK en carpetas
            'carpeta_id', // FK en tareas
            'id', // PK en aulas_docentes_materias
            'id' // PK en carpetas
        );
    }

    /**
     * Obtiene las trivias de esta relación aula-docente-materia.
     */
    public function trivias()
    {
        return $this->hasManyThrough(
            Trivia::class,
            Carpeta::class,
            'aulas_docentes_materias_id', // FK en carpetas
            'carpeta_id', // FK en trivias
            'id', // PK en aulas_docentes_materias
            'id' // PK en carpetas
        );
    }
}
