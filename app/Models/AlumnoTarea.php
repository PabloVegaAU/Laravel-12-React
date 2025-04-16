<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $alumno_id
 * @property int $tarea_id
 * @property string $estado
 * @property float $puntaje
 * @property string|null $comentario
 * @property \DateTime|null $hora_inicio
 * @property \DateTime|null $hora_final
 * @property int|null $tiempo_transcurrido
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 */
class AlumnoTarea extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'alumnos_tareas';

    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alumno_id',
        'tarea_id',
        'estado',
        'puntaje',
        'comentario',
        'hora_inicio',
        'hora_final',
        'tiempo_transcurrido',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'puntaje' => 'decimal:2',
        'hora_inicio' => 'datetime',
        'hora_final' => 'datetime',
        'tiempo_transcurrido' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene el alumno asociado al registro.
     */
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'user_id');
    }

    /**
     * Obtiene la tarea asociada al registro.
     */
    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }
}
