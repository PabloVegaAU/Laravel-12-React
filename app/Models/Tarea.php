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
 * @property string $descripcion
 * @property \DateTime $fecha_entrega
 * @property string $estado
 * @property int $carpeta_id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 */
class Tarea extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tareas';

    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_entrega',
        'estado',
        'carpeta_id',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_entrega' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene los alumnos asignados a esta tarea.
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(Alumno::class, 'alumnos_tareas', 'tarea_id', 'alumno_id')
            ->using(AlumnoTarea::class)
            ->withPivot([
                'estado',
                'puntaje',
                'comentario',
                'hora_inicio',
                'hora_final',
                'tiempo_transcurrido',
                'created_at',
                'updated_at',
            ]);
    }

    /**
     * Obtiene el registro de la tabla pivote alumnos_tareas.
     */
    public function alumnosTareas(): HasMany
    {
        return $this->hasMany(AlumnoTarea::class, 'tarea_id');
    }

    /**
     * Obtiene las actividades de la tarea.
     */
    public function actividades(): HasMany
    {
        return $this->hasMany(Actividad::class);
    }

    /**
     * Obtiene la carpeta a la que pertenece la tarea.
     */
    public function carpeta(): BelongsTo
    {
        return $this->belongsTo(Carpeta::class, 'carpeta_id');
    }
}
