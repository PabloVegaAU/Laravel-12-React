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
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);
            $table->text('descripcion');
            $table->enum('tipo', ['TAREA', 'RETO']);
            $table->enum('estado', ['INACTIVO', 'ACTIVO']);
            $table->unsignedBigInteger('carpeta_id');
            $table->timestamps();

            $table->foreign('carpeta_id')
                ->references('id')
                ->on('carpetas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
