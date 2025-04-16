<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $remitente_id
 * @property int $destinatario_id
 * @property string $asunto
 * @property string $contenido
 * @property bool $leido
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property User $remitente
 * @property User $destinatario
 */
class Mensaje extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mensajes';

    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'remitente_id',
        'destinatario_id',
        'asunto',
        'contenido',
        'leido',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'leido' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene el usuario que envió el mensaje.
     */
    public function remitente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'remitente_id');
    }

    /**
     * Obtiene el usuario destinatario del mensaje.
     */
    public function destinatario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }
}
