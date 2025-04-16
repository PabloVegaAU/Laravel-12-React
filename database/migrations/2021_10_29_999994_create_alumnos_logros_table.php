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
        Schema::create('alumnos_logros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('logro_id');
            $table->timestamps();

            $table->foreign('alumno_id')
                ->references('user_id')
                ->on('alumnos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('logro_id')
                ->references('id')
                ->on('logros')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos_logros');
    }
};
