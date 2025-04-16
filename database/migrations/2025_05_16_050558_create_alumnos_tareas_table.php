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
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('tarea_id');
            $table->integer('nota_final')->nullable();
            $table->timestamp('hora_inicio')->nullable();
            $table->timestamp('hora_final')->nullable();
            $table->text('tiempo_transcurrido')->nullable();
            $table->enum('estado', ['SIN RESPONSE', 'RESPONDIDO', 'CALIFICADO']);
            $table->timestamps();

            $table->foreign('alumno_id')
                ->references('user_id')
                ->on('alumnos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('tarea_id')
                ->references('id')
                ->on('tareas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
