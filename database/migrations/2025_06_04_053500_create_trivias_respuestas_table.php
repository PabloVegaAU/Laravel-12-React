<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trivias_respuestas', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('trivia_id')
                ->constrained('trivias')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('trivia_pregunta_id')
                ->constrained('trivias_preguntas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('trivia_pregunta_opcion_id')
                ->nullable()
                ->constrained('trivias_preguntas_opciones')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('alumno_id')
                ->constrained('alumnos', 'user_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('trivia_intento_id')
                ->nullable()
                ->constrained('trivias_intentos')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // Datos de la respuesta
            $table->text('respuesta_texto')->nullable()->comment('Para respuestas de texto libre');
            $table->decimal('puntaje_obtenidos', 8, 2)->default(0);
            $table->integer('tiempo_respuesta')->nullable()->comment('Tiempo en segundos');
            $table->boolean('es_correcta')->default(false);

            $table->timestamps();
            $table->softDeletes();

            // Índices para optimizar consultas comunes
            $table->index(['alumno_id', 'trivia_id']);
            $table->index(['trivia_pregunta_id', 'es_correcta']);
            $table->index(['trivia_intento_id', 'trivia_pregunta_id']);
            $table->index(['alumno_id', 'es_correcta']);
            $table->index('created_at');
            $table->index(['trivia_id', 'alumno_id'], 'idx_respuestas_alumno');
            $table->index(['trivia_pregunta_id', 'es_correcta'], 'idx_respuestas_correctas');
            $table->index(['trivia_intento_id', 'trivia_pregunta_id'], 'idx_respuestas_intento');

            // Índice compuesto para búsquedas rápidas
            $table->index(
                ['trivia_id', 'alumno_id', 'trivia_pregunta_id'],
                'idx_respuestas_completo'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trivias_respuestas');
    }
};
