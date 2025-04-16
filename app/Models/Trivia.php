<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $carpeta_id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $image
 * @property string $estado
 * @property float $puntaje_max
 * @property int $tiempo_limite
 * @property int $intentos_permitidos
 * @property bool $mostrar_respuestas
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 * @property Carpeta $carpeta
 * @property \Illuminate\Database\Eloquent\Collection|TriviaPregunta[] $preguntas
 * @property \Illuminate\Database\Eloquent\Collection|TriviaRespuesta[] $respuestas
 */
class Trivia extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'trivias';

    public $timestamps = true;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

    }

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'carpeta_id',
        'nombre',
        'descripcion',
        'image',
        'estado',
        'puntaje_max',
        'tiempo_limite',
        'intentos_permitidos',
        'mostrar_respuestas',
        'mostrar_puntaje',
        'creado_por',
        'actualizado_por',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'puntaje_max' => 'decimal:2',
        'tiempo_limite' => 'integer',
        'intentos_permitidos' => 'integer',
        'mostrar_respuestas' => 'boolean',
        'mostrar_puntaje' => 'boolean',
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
        'carpetas',
        'preguntas',
    ];

    /**
     * The relationships that should always be loaded with count.
     *
     * @var array
     */
    protected $withCount = [
        'preguntas',
        'respuestas',
        'intentos',
    ];

    /**
     * Obtiene la carpeta a la que pertenece la trivia.
     */
    public function carpetas(): BelongsToMany
    {
        return $this->belongsToMany(Carpeta::class, 'carpetas_trivias');
    }

    /**
     * Obtiene las preguntas de la trivia.
     */
    public function preguntas(): HasMany
    {
        return $this->hasMany(TriviaPregunta::class, 'trivia_id');
    }

    /**
     * Obtiene las respuestas de la trivia a través de las preguntas.
     */
    public function respuestas(): HasManyThrough
    {
        return $this->hasManyThrough(
            TriviaRespuesta::class,
            TriviaPregunta::class,
            'trivia_id',
            'trivia_pregunta_id',
            'id',
            'id'
        );
    }
}
