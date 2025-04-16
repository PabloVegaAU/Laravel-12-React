<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividads', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->text('recurso')->nullable();
            $table->enum('tipo',[0,1,2,3]);

             /*
             * 0 = pregunta corta
             * 1 = pregunta larga
             * 2 = video  (mira el video y responde)
             * 3 = link drive
             *
             * ESTOS LINKS VAN EN RECURSOS
             */

            $table->double('puntaje_max',4, 1)->nullable();
            $table->unsignedBigInteger('tarea_id');
            $table->timestamps();

            $table->foreign('tarea_id')
            ->references('id')
            ->on('tareas')
            ->onDelete('cascade')
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
        Schema::dropIfExists('actividads');
    }
}
