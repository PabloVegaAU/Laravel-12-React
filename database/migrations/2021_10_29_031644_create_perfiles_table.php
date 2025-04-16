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
        Schema::create('perfiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->date('fecha_nac');
            $table->string('dni', 8)->unique();
            $table->integer('edad');
            $table->enum('sexo', ['m', 'f']);
            $table->text('direccion');
            $table->text('distrito');
            $table->timestamps();
            $table->primary('user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfiles');
    }
};
