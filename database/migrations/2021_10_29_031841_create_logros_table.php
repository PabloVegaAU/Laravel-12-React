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
        Schema::create('logros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->enum('tipo', ['BASICO', 'REGULAR', 'NORMAL', 'BUENO', 'MUY BUENO', 'EXCELENTE']);
            $table->integer('exp_req')->nullable();
            $table->boolean('es_comprable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logros');
    }
};
