<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo que representa un intento de resolución de una trivia por un alumno.
 *
 * @property int $id
 * @property int $trivia_id
 * @property int $alumno_id
 * @property int $intento_numero
 * @property \Illuminate\Support\Carbon $fecha_inicio
 * @property \Illuminate\Support\Carbon|null $fecha_fin
 * @property int|null $tiempo_utilizado Tiempo en segundos
 * @property float $puntaje_total
 * @property float $puntaje_maximo
 * @property float $porcentaje_exito
 * @property bool $completado
 * @property bool $aprobado
 * @property bool $es_simulacro
 * @property bool $es_revision
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Trivia $trivia
 * @property-read Alumno $alumno
 * @property-read \Illuminate\Database\Eloquent\Collection|TriviaRespuesta[] $respuestas
 */
class TriviaIntento extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'trivias_intentos';

    protected $fillable = [
        'trivia_id',
        'alumno_id',
        'intento_numero',
        'fecha_inicio',
        'fecha_fin',
        'tiempo_utilizado',
        'puntaje_total',
        'puntaje_maximo',
        'porcentaje_exito',
        'completado',
        'aprobado',
        'es_simulacro',
        'es_revision'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'tiempo_utilizado' => 'integer',
        'puntaje_total' => 'decimal:2',
        'puntaje_maximo' => 'decimal:2',
        'porcentaje_exito' => 'decimal:2',
        'completado' => 'boolean',
        'aprobado' => 'boolean',
        'es_simulacro' => 'boolean',
        'es_revision' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'tiempo_promedio_por_pregunta',
    ];

    /**
     * Obtiene la trivia asociada a este intento.
     */
    public function trivia(): BelongsTo
    {
        return $this->belongsTo(Trivia::class);
    }

    /**
     * Obtiene el alumno que realizó el intento.
     */
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'user_id');
    }

    /**
     * Obtiene las respuestas de este intento.
     */
    public function respuestas(): HasMany
    {
        return $this->hasMany(TriviaRespuesta::class, 'trivia_intento_id');
    }

    /**
     * Marca el intento como completado.
     */
    public function marcarComoCompletado(): bool
    {
        if ($this->completado) {
            return true;
        }

        $this->fecha_fin = now();
        $this->tiempo_utilizado = $this->fecha_fin->diffInSeconds($this->fecha_inicio);
        $this->completado = true;

        // Calcular porcentaje de éxito
        if ($this->puntaje_maximo > 0) {
            $this->porcentaje_exito = ($this->puntaje_total / $this->puntaje_maximo) * 100;
            $this->aprobado = $this->porcentaje_exito >= $this->trivia->porcentaje_aprobacion;
        }

        return $this->save();
    }

    /**
     * Actualiza el puntaje total del intento.
     */
    public function actualizarPuntaje(): void
    {
        $this->puntaje_total = $this->respuestas()->sum('puntaje_obtenido');
        $this->save();
    }

    /**
     * Obtiene el tiempo promedio por pregunta en segundos.
     */
    public function getTiempoPromedioPorPreguntaAttribute(): ?float
    {
        if (! $this->tiempo_utilizado || $this->respuestas->isEmpty()) {
            return null;
        }

        return round($this->tiempo_utilizado / $this->respuestas->count(), 2);
    }

    /**
     * Scope para obtener solo intentos completados.
     */
    public function scopeCompletados(Builder $query): Builder
    {
        return $query->where('completado', true);
    }

    /**
     * Scope para obtener solo intentos aprobados.
     */
    public function scopeAprobados(Builder $query): Builder
    {
        return $query->where('aprobado', true);
    }

    /**
     * Scope para obtener intentos de un alumno específico.
     */
    public function scopePorAlumno(Builder $query, int $alumnoId): Builder
    {
        return $query->where('alumno_id', $alumnoId);
    }

    /**
     * Obtiene estadísticas detalladas del intento.
     */
    public function obtenerEstadisticas(): array
    {
        $totalPreguntas = $this->trivia->preguntas()->count();
        $respuestas = $this->respuestas()->with('pregunta')->get();

        $correctas = $respuestas->where('es_correcta', true)->count();
        $incorrectas = $respuestas->where('es_correcta', false)->count();
        $sinResponder = $totalPreguntas - $respuestas->count();

        $tiempoPromedio = $this->tiempo_promedio_por_pregunta;

        return [
            'total_preguntas' => $totalPreguntas,
            'respondidas' => $respuestas->count(),
            'correctas' => $correctas,
            'incorrectas' => $incorrectas,
            'sin_responder' => $sinResponder,
            'puntaje_obtenido' => (float) $this->puntaje_total,
            'puntaje_maximo' => (float) $this->puntaje_maximo,
            'porcentaje_exito' => (float) $this->porcentaje_exito,
            'tiempo_total_segundos' => $this->tiempo_utilizado,
            'tiempo_promedio_por_pregunta' => $tiempoPromedio,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'aprobado' => $this->aprobado,
        ];
    }
}
