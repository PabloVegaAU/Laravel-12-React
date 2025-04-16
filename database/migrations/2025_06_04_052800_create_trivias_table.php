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
        Schema::create('trivias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('image')->nullable();
            $table->enum('estado', ['borrador', 'eliminada', 'activa'])->default('borrador');
            $table->decimal('puntaje_max', 8, 2)->default(0);
            $table->integer('tiempo_limite')->nullable()->comment('Tiempo en segundos');
            $table->unsignedTinyInteger('intentos_permitidos')->default(1);
            $table->boolean('mostrar_respuestas')->default(true);
            $table->boolean('mostrar_puntaje')->default(true);

            $table->unsignedBigInteger('creado_por')->nullable();
            $table->unsignedBigInteger('actualizado_por')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('creado_por')
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('actualizado_por')
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trivias');
    }
};
