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
 * @property int $anio
 * @property int $grado_id
 * @property int $seccion_id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 * @property Grado $grado
 * @property Seccion $seccion
 * @property \Illuminate\Database\Eloquent\Collection|Alumno[] $alumnos
 * @property \Illuminate\Database\Eloquent\Collection|AulaDocenteMateria[] $docentesMaterias
 */
class Aula extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'aulas';

    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'anio',
        'grado_id',
        'seccion_id',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'anio' => 'integer',
        'grado_id' => 'integer',
        'seccion_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene los alumnos inscritos en esta aula.
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(
            Alumno::class,
            'aulas_alumnos',
            'aula_id',
            'alumno_id',
            'id',
            'user_id'
        )->withPivot('es_actual', 'estado')
            ->withTimestamps();
    }

    /**
     * Obtiene las asignaciones de docentes y materias para esta aula.
     */
    public function docentesMaterias(): HasMany
    {
        return $this->hasMany(AulaDocenteMateria::class, 'aula_id');
    }

    /**
     * Obtiene la sección a la que pertenece el aula.
     */
    public function seccion(): BelongsTo
    {
        return $this->belongsTo(Seccion::class, 'seccion_id');
    }

    /**
     * Obtiene el grado al que pertenece el aula.
     */
    public function grado(): BelongsTo
    {
        return $this->belongsTo(Grado::class, 'grado_id');
    }
}
