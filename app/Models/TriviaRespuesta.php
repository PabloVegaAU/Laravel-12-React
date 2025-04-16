<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo que representa una respuesta de un alumno a una pregunta de trivia.
 *
 * @property int $id
 * @property int $trivia_id
 * @property int $trivia_pregunta_id
 * @property int|null $trivia_pregunta_opcion_id
 * @property int $alumno_id
 * @property int|null $trivia_intento_id
 * @property string|null $respuesta_texto
 * @property float $puntaje_obtenido
 * @property int|null $tiempo_respuesta Tiempo en segundos
 * @property bool $es_correcta
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read Trivia $trivia
 * @property-read TriviaPregunta $pregunta
 * @property-read TriviaPreguntaOpcion|null $opcion
 * @property-read Alumno $alumno
 * @property-read TriviaIntento|null $intento
 * @property-read float $tiempo_promedio_por_pregunta
 */
class TriviaRespuesta extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'trivias_respuestas';

    protected $fillable = [
        'trivia_id',
        'trivia_pregunta_id',
        'trivia_pregunta_opcion_id',
        'alumno_id',
        'trivia_intento_id',
        'respuesta_texto',
        'puntaje_obtenido',
        'tiempo_respuesta',
        'es_correcta'
    ];

    protected $casts = [
        'puntaje_obtenido' => 'decimal:2',
        'tiempo_respuesta' => 'integer',
        'es_correcta' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['tiempo_promedio_por_pregunta'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $with = [
        'opcion',
        'pregunta',
    ];

    /**
     * Obtiene el tiempo promedio por pregunta en segundos.
     */
    public function getTiempoPromedioPorPreguntaAttribute(): ?float
    {
        if (! $this->tiempo_respuesta) {
            return null;
        }

        return round($this->tiempo_respuesta, 2);
    }

    /**
     * Obtiene la trivia a la que pertenece esta respuesta.
     */
    public function trivia(): BelongsTo
    {
        return $this->belongsTo(Trivia::class, 'trivia_id');
    }

    /**
     * Obtiene la pregunta a la que pertenece esta respuesta.
     */
    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(TriviaPregunta::class, 'trivia_pregunta_id');
    }

    /**
     * Obtiene la opción seleccionada en esta respuesta.
     */
    public function opcion(): BelongsTo
    {
        return $this->belongsTo(TriviaPreguntaOpcion::class, 'trivia_pregunta_opcion_id');
    }

    /**
     * Obtiene el alumno que realizó esta respuesta.
     */
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'user_id');
    }

    /**
     * Obtiene el intento al que pertenece esta respuesta.
     */
    public function intento(): BelongsTo
    {
        return $this->belongsTo(TriviaIntento::class, 'trivia_intento_id');
    }

    /**
     * Scope para obtener solo respuestas correctas.
     */
    public function scopeCorrectas(Builder $query): Builder
    {
        return $query->where('es_correcta', true);
    }

    /**
     * Scope para obtener respuestas de un intento específico.
     */
    public function scopePorIntento(Builder $query, int $intentoId): Builder
    {
        return $query->where('trivia_intento_id', $intentoId);
    }

    /**
     * Marca la respuesta como correcta y asigna puntaje.
     */
    public function marcarComoCorrecta(float $puntaje): bool
    {
        $this->es_correcta = true;
        $this->puntaje_obtenido = $puntaje;
        $this->retroalimentacion = $this->opcion->retroalimentacion ?? '¡Respuesta correcta!';

        return $this->save();
    }

    /**
     * Marca la respuesta como incorrecta.
     */
    public function marcarComoIncorrecta(?string $retroalimentacion = null): bool
    {
        $this->es_correcta = false;
        $this->puntaje_obtenido = 0;
        $this->retroalimentacion = $retroalimentacion ?? ($this->opcion->retroalimentacion ?? 'Respuesta incorrecta.');

        return $this->save();
    }
}
