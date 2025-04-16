<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Modelo que representa una pregunta dentro de una trivia.
 *
 * @property int $id ID único de la pregunta
 * @property int $trivia_id ID de la trivia a la que pertenece
 * @property string $pregunta Texto de la pregunta
 * @property string|null $explicacion Explicación detallada de la respuesta correcta
 * @property float $puntaje Puntaje que otorga la pregunta al ser respondida correctamente
 * @property int $orden Orden de aparición de la pregunta en la trivia
 * @property bool $es_obligatoria Indica si la pregunta es obligatoria de responder
 * @property string|null $tipo Tipo de pregunta (opcion_unica, opcion_multiple, verdadero_falso, etc.)
 * @property \Illuminate\Support\Carbon $created_at Fecha de creación
 * @property \Illuminate\Support\Carbon $updated_at Fecha de última actualización
 * @property-read Trivia $trivia Trivia a la que pertenece la pregunta
 * @property-read Collection|TriviaPreguntaOpcion[] $opciones Opciones de respuesta asociadas
 * @property-read Collection|TriviaRespuesta[] $respuestas Respuestas de los alumnos
 * @property-read Collection|TriviaPreguntaOpcion[] $respuestasCorrectas Opciones correctas de la pregunta
 * @property-read Collection|TriviaPreguntaOpcion[] $opcionesOrdenadas Opciones ordenadas por el campo 'orden'
 */
class TriviaPregunta extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * @var string Nombre de la tabla en la base de datos
     */
    protected $table = 'trivias_preguntas';

    /**
     * @var bool Indica si el modelo debe tener marcas de tiempo
     */
    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'trivia_id',
        'pregunta',
        'explicacion',
        'puntaje',
        'orden',
        'es_obligatoria',
        'tipo',
        'imagen',
        'aleatorizar_opciones'
    ];

    /**
     * Tipos de preguntas disponibles.
     *
     * @var array
     */
    public const TIPOS = [
        'opcion_unica' => 'Opción Única',
        'opcion_multiple' => 'Opción Múltiple',
        'verdadero_falso' => 'Verdadero/Falso',
        'emparejamiento' => 'Emparejamiento',
        'ordenar_opciones' => 'Ordenar Opciones',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'es_obligatoria' => 'boolean',
        'puntaje' => 'decimal:2',
        'orden' => 'integer',
        'aleatorizar_opciones' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $with = [
        'opciones',
        'trivia',
    ];

    /**
     * The relationships that should always be loaded with count.
     *
     * @var array
     */
    protected $withCount = [
        'opciones',
        'respuestas',
    ];

    /**
     * Valores por defecto para los atributos del modelo.
     *
     * @var array
     */
    protected $attributes = [
        'es_obligatoria' => true,
        'puntaje' => 1.0,
        'orden' => 1,
        'tipo' => 'opcion_unica',
    ];

    /**
     * Obtiene la trivia a la que pertenece la pregunta.
     */
    public function trivia(): BelongsTo
    {
        return $this->belongsTo(Trivia::class, 'trivia_id')
            ->withDefault();
    }

    /**
     * Obtiene las opciones de respuesta de la pregunta.
     */
    public function opciones(): HasMany
    {
        return $this->hasMany(TriviaPreguntaOpcion::class, 'trivia_pregunta_id');
    }

    /**
     * Obtiene las opciones de respuesta ordenadas por el campo 'orden'.
     */
    public function opcionesOrdenadas(): HasMany
    {
        return $this->opciones()->orderBy('orden');
    }

    /**
     * Obtiene las respuestas a esta pregunta.
     */
    public function respuestas()
    {
        return $this->hasMany(TriviaRespuesta::class, 'trivia_pregunta_id');
    }

    /**
     * Obtiene el tiempo promedio de respuesta a esta pregunta en segundos.
     */
    public function getTiempoPromedioRespuestaAttribute(): ?float
    {
        $tiempoPromedio = $this->respuestas()
            ->whereNotNull('tiempo_respuesta')
            ->avg('tiempo_respuesta');

        return $tiempoPromedio ? round($tiempoPromedio, 2) : null;
    }

    /**
     * Obtiene estadísticas de respuestas para esta pregunta.
     */
    public function obtenerEstadisticasRespuestas(): array
    {
        $totalRespuestas = $this->respuestas()->count();
        $respuestasCorrectas = $this->respuestas()->where('es_correcta', true)->count();
        $porcentajeCorrectas = $totalRespuestas > 0
            ? round(($respuestasCorrectas / $totalRespuestas) * 100, 2)
            : 0;

        $opciones = $this->opciones()
            ->withCount(['respuestas as veces_seleccionada'])
            ->get()
            ->map(function ($opcion) use ($totalRespuestas) {
                $porcentaje = $totalRespuestas > 0
                    ? round(($opcion->veces_seleccionada / $totalRespuestas) * 100, 2)
                    : 0;

                return [
                    'id' => $opcion->id,
                    'opcion' => $opcion->opcion,
                    'es_correcta' => $opcion->es_correcta,
                    'veces_seleccionada' => $opcion->veces_seleccionada,
                    'porcentaje_seleccion' => $porcentaje,
                ];
            });

        return [
            'total_respuestas' => $totalRespuestas,
            'respuestas_correctas' => $respuestasCorrectas,
            'porcentaje_correctas' => $porcentajeCorrectas,
            'tiempo_promedio_respuesta' => $this->tiempo_promedio_respuesta,
            'opciones' => $opciones,
        ];
    }

    /**
     * Obtiene las opciones de respuesta correctas para esta pregunta.
     */
    public function respuestasCorrectas(): HasMany
    {
        return $this->opciones()->where('es_correcta', true);
    }

    /**
     * Scope para obtener solo preguntas obligatorias.
     */
    public function scopeObligatorias(Builder $query): Builder
    {
        return $query->where('es_obligatoria', true);
    }

    /**
     * Scope para ordenar las preguntas por el campo 'orden'.
     */
    public function scopeOrdenadas(Builder $query, string $direccion = 'asc'): Builder
    {
        return $query->orderBy('orden', $direccion);
    }

    /**
     * Verifica si la pregunta es de opción múltiple.
     */
    public function esOpcionMultiple(): bool
    {
        return $this->tipo === 'opcion_multiple';
    }

    /**
     * Verifica si la pregunta es de opción única.
     */
    public function esOpcionUnica(): bool
    {
        return $this->tipo === 'opcion_unica';
    }

    /**
     * Verifica si la pregunta es de tipo verdadero/falso.
     */
    public function esVerdaderoFalso(): bool
    {
        return $this->tipo === 'verdadero_falso';
    }

    /**
     * Obtiene el texto descriptivo del tipo de pregunta.
     */
    public function getTipoTextoAttribute(): string
    {
        return self::TIPOS[$this->tipo] ?? 'Desconocido';
    }

    /**
     * Verifica si una opción dada es la respuesta correcta.
     */
    public function esRespuestaCorrecta(int $opcionId): bool
    {
        return $this->respuestasCorrectas()->where('id', $opcionId)->exists();
    }

    /**
     * Obtiene las estadísticas de respuestas para esta pregunta.
     */
    public function obtenerEstadisticas(): array
    {
        $totalRespuestas = $this->respuestas()->count();

        if ($totalRespuestas === 0) {
            return [
                'total' => 0,
                'correctas' => 0,
                'incorrectas' => 0,
                'porcentaje_correctas' => 0,
                'porcentaje_incorrectas' => 0,
            ];
        }

        $correctas = $this->respuestas()
            ->whereHas('opcion', function ($query) {
                $query->where('es_correcta', true);
            })
            ->count();

        $incorrectas = $totalRespuestas - $correctas;

        return [
            'total' => $totalRespuestas,
            'correctas' => $correctas,
            'incorrectas' => $incorrectas,
            'porcentaje_correctas' => round(($correctas / $totalRespuestas) * 100, 2),
            'porcentaje_incorrectas' => round(($incorrectas / $totalRespuestas) * 100, 2),
        ];
    }
}
