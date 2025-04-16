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
        Schema::create('aulas_alumnos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aula_id')
                ->constrained('aulas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('alumno_id')
                ->constrained('alumnos', 'user_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->boolean('es_actual');
            $table->enum('estado', ['RETIRADO', 'ACTIVO', 'GRADUADO']);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['aula_id', 'alumno_id']);
            $table->index(['alumno_id', 'es_actual']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aulas_alumnos');
    }
};
