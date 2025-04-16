<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $titulo
 * @property string|null $descripcion
 * @property \DateTime|null $fecha_inicio
 * @property \DateTime|null $fecha_final
 * @property int $aulas_docentes_materias_id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 * @property AulaDocenteMateria $aulaDocenteMateria
 * @property \Illuminate\Database\Eloquent\Collection|Tarea[] $tareas
 * @property \Illuminate\Database\Eloquent\Collection|Trivia[] $trivias
 */
class Carpeta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'carpetas';

    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'aulas_docentes_materias_id',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_final' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene las tareas de la carpeta.
     */
    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'carpeta_id');
    }

    /**
     * Obtiene las trivias de la carpeta.
     */
    public function trivias(): BelongsToMany
    {
        return $this->belongsToMany(Trivia::class, 'carpetas_trivias');
    }

    /**
     * Obtiene la relación de aula, docente y materia asociados a esta carpeta.
     */
    public function aulaDocenteMateria(): BelongsTo
    {
        return $this->belongsTo(AulaDocenteMateria::class, 'aulas_docentes_materias_id');
    }
}
