<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $tipo
 * @property float $exp_req
 * @property string $icono
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 */
class Logro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'logros';

    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo',
        'exp_req',
        'icono',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'exp_req' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene los alumnos que han obtenido este logro.
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(
            Alumno::class,
            'alumnos_logros',
            'logro_id',
            'alumno_id',
            'id',
            'user_id'
        )->withTimestamps();
    }

    /**
     * Obtiene los registros de la tabla pivote alumnos_logros.
     */
    public function alumnosLogros()
    {
        return $this->hasMany(AlumnoLogro::class, 'logro_id');
    }
}
