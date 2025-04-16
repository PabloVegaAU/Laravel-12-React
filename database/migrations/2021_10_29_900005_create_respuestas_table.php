<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',1000)->default('-');
            $table->double('puntaje',4,1)->nullable();

            $table->unsignedBigInteger('actividad_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();

            $table->foreign('actividad_id')
            ->references('id')
            ->on('actividads')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('user_id')
            ->references('user_id')
            ->on('alumnos')
            ->onDelete('set null')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuestas');
    }
}
