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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 1000)->default('-');
            $table->decimal('puntaje', 5, 2)->nullable();

            $table->foreignId('actividad_id')
                ->constrained('actividades')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('alumno_id')
                ->constrained('alumnos', 'user_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
