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
            $table->unsignedBigInteger('aula_id');
            $table->unsignedBigInteger('alumno_id');
            $table->boolean('es_actual');
            $table->enum('estado', ['RETIRADO', 'ACTIVO', 'GRADUADO']);
            $table->timestamps();

            $table->foreign('aula_id')
                ->references('id')
                ->on('aulas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('alumno_id')
                ->references('user_id')
                ->on('alumnos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
