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
 * @property string $nombre
 * @property string $descripcion
 * @property string $color
 * @property string $icono
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 */
class Materia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materias';

    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
        'icono',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene las aulas donde se imparte esta materia a través de la tabla intermedia.
     */
    public function aulas(): HasMany
    {
        return $this->hasMany(AulaDocenteMateria::class, 'materia_id', 'id');
    }

    /**
     * Obtiene las carpetas de esta materia a través de la relación con AulaDocenteMateria.
     */
    public function carpetas(): HasManyThrough
    {
        return $this->hasManyThrough(
            Carpeta::class,
            AulaDocenteMateria::class,
            'materia_id', // Clave foránea en la tabla intermedia (aulas_docentes_materias)
            'aulas_docentes_materias_id', // Clave foránea en la tabla destino (carpetas)
            'id', // Clave local en esta tabla (materias)
            'id'  // Clave local en la tabla intermedia (aulas_docentes_materias)
        );
    }

    /**
     * Obtiene los docentes que imparten esta materia.
     */
    public function docentes(): BelongsToMany
    {
        return $this->belongsToMany(
            Docente::class,
            'aulas_docentes_materias',
            'materia_id',
            'docente_id',
            'id',
            'user_id'
        )->withPivot('aula_id');
    }
}
