<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnoTareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno_tarea', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tarea_id');
            $table->integer('nota_final')->nullable();
            $table->timestamp('hora_inicio')->nullable();
            $table->timestamp('hora_final')->nullable();
            $table->text('tiempo_transcurrido')->nullable();
            $table->enum('estado',[0,1,2])->default(0);

            /*
             * 0 = sin responder
             * 1 = respondido
             * 2 = calificado
             */

            $table->timestamps();

            $table->foreign('user_id')
            ->references('user_id')
            ->on('alumnos')
            ->onDelete('cascade')
            ->onDelete('cascade');

            $table->foreign('tarea_id')
            ->references('id')
            ->on('tareas')
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
        Schema::dropIfExists('alumno_tarea');
    }
}
