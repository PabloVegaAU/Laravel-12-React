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
        Schema::create('carpetas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);
            $table->text('descripcion');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->enum('estado', ['CERRADO', 'ABIERTO']);
            $table->unsignedBigInteger('aulas_docentes_materias_id')->nullable();
            $table->timestamps();

            $table->foreign('aulas_docentes_materias_id')
                ->references('id')
                ->on('aulas_docentes_materias')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carpetas');
    }
};
