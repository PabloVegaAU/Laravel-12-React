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

            $table->foreignId('docente_id')
                ->constrained('docentes', 'user_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('aula_id')
                ->constrained('aulas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('materia_id')
                ->constrained('materias')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['aula_id', 'docente_id', 'materia_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aulas_docentes_materias', function (Blueprint $table) {
            $table->dropForeign(['aula_id']);
            $table->dropForeign(['docente_id']);
            $table->dropForeign(['materia_id']);
        });
        Schema::dropIfExists('aulas_docentes_materias');
    }
};
