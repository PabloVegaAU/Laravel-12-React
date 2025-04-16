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
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->text('recurso')->nullable();
            $table->enum('tipo', ['PREGUNTA CORTA', 'PREGUNTA LARGA', 'VIDEO', 'LINK']);
            $table->decimal('puntaje_max', 5, 2)->nullable();

            $table->foreignId('tarea_id')
                ->nullable()
                ->constrained('tareas')
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
        Schema::dropIfExists('actividades');
    }
};
