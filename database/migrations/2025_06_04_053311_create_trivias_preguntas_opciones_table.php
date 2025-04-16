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
        Schema::create('trivias_preguntas_opciones', function (Blueprint $table) {
            $table->id();

            // Relación con la pregunta
            $table->foreignId('trivia_pregunta_id')
                ->constrained('trivias_preguntas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // Contenido de la opción
            $table->text('texto');
            $table->text('imagen')->nullable();
            $table->text('audio_url')->nullable();
            $table->string('color', 20)->nullable();

            // Configuración
            $table->boolean('es_correcta')->default(false);
            $table->decimal('puntaje', 8, 2)->nullable()->comment('Puntaje específico para esta opción');
            $table->unsignedTinyInteger('orden')->default(0);

            // Para preguntas de emparejamiento
            $table->string('clave_emparejamiento', 50)->nullable()->comment('Para opciones que deben emparejarse');

            // Metadatos
            $table->unsignedBigInteger('creado_por')->nullable();
            $table->unsignedBigInteger('actualizado_por')->nullable();

            // Relación con usuarios
            $table->foreign('creado_por')
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('actualizado_por')
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
            $table->softDeletes();

            // Índices para búsquedas comunes con nombres más cortos
            $table->index(['trivia_pregunta_id', 'es_correcta'], 'idx_preg_opc_correcta');
            $table->index(['trivia_pregunta_id', 'clave_emparejamiento'], 'idx_preg_opc_emparejamiento');
            $table->index(['trivia_pregunta_id', 'orden'], 'idx_preg_opc_orden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trivias_preguntas_opciones');
    }
};
