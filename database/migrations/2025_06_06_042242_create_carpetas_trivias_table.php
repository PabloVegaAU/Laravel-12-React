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
        Schema::create('carpetas_trivias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('carpeta_id')
                ->constrained('carpetas')
                ->cascadeOnDelete();

            $table->foreignId('trivia_id')
                ->constrained('trivias')
                ->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Índices y restricciones
            $table->unique(['carpeta_id', 'trivia_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carpetas_trivias');
    }
};
