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
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seccion_id')->nullable();
            $table->unsignedBigInteger('grado_id')->nullable();
            $table->year('anio');
            $table->timestamps();

            $table->foreign('seccion_id')
                ->references('id')
                ->on('secciones')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('grado_id')
                ->references('id')
                ->on('grados')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aulas');
    }
};
