<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo que representa una opción de respuesta para una pregunta de trivia.
 *
 * @property int $id ID único de la opción
 * @property int $trivia_pregunta_id ID de la pregunta asociada
 * @property string $opcion Texto de la opción de respuesta
 * @property bool $es_correcta Indica si la opción es correcta
 * @property string|null $retroalimentacion Retroalimentación que se muestra al seleccionar esta opción
 * @property int $orden Orden en que se muestra la opción
 * @property \Illuminate\Support\Carbon $created_at Fecha de creación
 * @property \Illuminate\Support\Carbon $updated_at Fecha de última actualización
 * @property-read TriviaPregunta $pregunta Pregunta a la que pertenece esta opción
 * @property-read \Illuminate\Database\Eloquent\Collection|TriviaRespuesta[] $respuestas Respuestas que han seleccionado esta opción
 */
class TriviaPreguntaOpcion extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * @var string Nombre de la tabla en la base de datos
     */
    protected $table = 'trivias_preguntas_opciones';

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
        'trivia_pregunta_id',
        'texto',
        'imagen',
        'audio_url',
        'color',
        'es_correcta',
        'puntaje',
        'orden',
        'clave_emparejamiento',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'es_correcta' => 'boolean',
        'puntaje' => 'decimal:2',
        'orden' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Los atributos que deben ser tratados como fechas.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Los accesos que deben ser incluidos en la forma de matriz del modelo.
     *
     * @var array
     */
    protected $with = [
        'pregunta',
    ];

    /**
     * Obtiene la pregunta a la que pertenece esta opción.
     */
    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(TriviaPregunta::class, 'trivia_pregunta_id')
            ->withDefault(); // Asegura que nunca sea nulo
    }

    /**
     * Obtiene las respuestas de los alumnos que seleccionaron esta opción.
     */
    public function respuestas(): HasMany
    {
        return $this->hasMany(TriviaRespuesta::class, 'trivia_pregunta_opcion_id');
    }

    /**
     * Scope para obtener solo las opciones correctas.
     */
    public function scopeCorrectas(Builder $query): Builder
    {
        return $query->where('es_correcta', true);
    }

    /**
     * Scope para obtener solo las opciones incorrectas.
     */
    public function scopeIncorrectas(Builder $query): Builder
    {
        return $query->where('es_correcta', false);
    }

    /**
     * Scope para ordenar por el campo 'orden' de forma ascendente.
     */
    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderBy('orden');
    }

    /**
     * Verifica si esta opción es la única correcta para su pregunta.
     */
    public function esUnicaCorrecta(): bool
    {
        if (! $this->es_correcta) {
            return false;
        }

        return $this->pregunta->opciones()
            ->where('id', '!=', $this->id)
            ->correctas()
            ->doesntExist();
    }
}
