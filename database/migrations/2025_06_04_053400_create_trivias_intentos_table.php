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
        Schema::create('trivias_intentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trivia_id')->constrained('trivias')->onDelete('cascade');
            $table->foreignId('alumno_id')->constrained('alumnos', 'user_id')->onDelete('cascade');
            $table->unsignedTinyInteger('intento_numero');
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_fin')->nullable();
            $table->unsignedInteger('tiempo_utilizado')->nullable()->comment('Tiempo en segundos');
            $table->decimal('puntaje_total', 8, 2)->default(0);
            $table->decimal('puntaje_maximo', 8, 2);
            $table->decimal('porcentaje_exito', 5, 2)->default(0);
            $table->boolean('completado')->default(false);
            $table->boolean('aprobado')->default(false);
            $table->boolean('es_simulacro')->default(false);
            $table->boolean('es_revision')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['trivia_id', 'alumno_id']);
            $table->index('intento_numero');
            $table->index('fecha_inicio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trivias_intentos');
    }
};
