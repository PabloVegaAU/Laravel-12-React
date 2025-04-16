<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $descripcion
 * @property string|null $recurso
 * @property string $tipo
 * @property float $puntaje_max
 * @property int $tarea_id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 */
class Actividad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'actividades';

    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'descripcion',
        'recurso',
        'tipo',
        'puntaje_max',
        'tarea_id',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'puntaje_max' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene las respuestas de los alumnos para esta actividad.
     */
    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class);
    }

    /**
     * Obtiene la tarea a la que pertenece esta actividad.
     */
    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }
}
