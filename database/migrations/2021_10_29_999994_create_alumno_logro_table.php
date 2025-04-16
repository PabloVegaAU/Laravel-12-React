<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnoLogroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno_logro', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('logro_id');

            $table->timestamps();

            $table->foreign('user_id')
            ->references('user_id')
            ->on('alumnos')
            ->onDelete('cascade')
            ->onDelete('cascade');

            $table->foreign('logro_id')
            ->references('id')
            ->on('logros')
            ->onDelete('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumno_logro');
    }
}
