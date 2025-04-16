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
        Schema::create('trivias_preguntas', function (Blueprint $table) {
            $table->id();

            // Relación con trivias
            $table->foreignId('trivia_id')
                ->constrained('trivias')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // Contenido de la pregunta
            $table->text('pregunta');
            $table->text('explicacion')->nullable();
            $table->text('imagen')->nullable();

            // Tipo de pregunta
            $table->enum('tipo', [
                'opcion_unica',
                'opcion_multiple',
                'verdadero_falso',
                'emparejamiento',
                'ordenar_opciones',
            ])->default('opcion_unica');

            $table->decimal('puntaje', 8, 2)->default(1.00);
            $table->unsignedTinyInteger('orden')->default(0);
            $table->boolean('es_obligatoria')->default(true);

            $table->unsignedBigInteger('creado_por')->nullable();
            $table->unsignedBigInteger('actualizado_por')->nullable();

            // Foreign keys
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

            // Índices para búsquedas comunes
            $table->index(['tipo', 'es_obligatoria']);
            $table->index(['trivia_id', 'orden'], 'idx_preguntas_orden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trivias_preguntas');
    }
};
