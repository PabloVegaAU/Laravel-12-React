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
        Schema::create('aulas_docentes_materias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aula_id');
            $table->unsignedBigInteger('docente_id');
            $table->unsignedBigInteger('materia_id');

            $table->timestamps();

            $table->foreign('docente_id')
                ->references('user_id')
                ->on('docentes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('aula_id')
                ->references('id')
                ->on('aulas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('materia_id')
                ->references('id')
                ->on('materias')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unique(['aula_id', 'docente_id', 'materia_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aulas_docentes_materias', function (Blueprint $table) {
            $table->dropForeign(['docente_id']);
        });
        Schema::dropIfExists('aulas_docentes_materias');
    }
};
