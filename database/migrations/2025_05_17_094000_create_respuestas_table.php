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
            $table->double('puntaje', 4, 2)->nullable();
            $table->unsignedBigInteger('actividad_id');
            $table->unsignedBigInteger('alumno_id');
            $table->timestamps();

            $table->foreign('actividad_id')
                ->references('id')
                ->on('actividades')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('alumno_id')
                ->references('user_id')
                ->on('alumnos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
