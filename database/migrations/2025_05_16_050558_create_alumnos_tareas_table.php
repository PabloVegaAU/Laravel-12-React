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
        Schema::create('alumnos_tareas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alumno_id')
                ->constrained('alumnos', 'user_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('tarea_id')
                ->constrained('tareas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->integer('nota_final')->nullable();
            $table->timestamp('hora_inicio')->nullable();
            $table->timestamp('hora_final')->nullable();
            $table->text('tiempo_transcurrido')->nullable();
            $table->enum('estado', ['SIN RESPONSE', 'RESPONDIDO', 'CALIFICADO']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos_tareas');
    }
};
