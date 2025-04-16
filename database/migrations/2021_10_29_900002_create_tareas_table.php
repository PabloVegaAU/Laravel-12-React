<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',100);
            $table->text('descripcion');
            $table->enum('tipo',[0,1]);
            /*
                0 = tarea normal
                1 = reto
             */
            $table->enum('estado',[0,1]);

            /**
             * 0 = inactivo (por el docente)
             * 1 = activo (por el docente)
             *
             */

            $table->unsignedBigInteger('carpeta_id');

            $table->timestamps();

            $table->foreign('carpeta_id')
            ->references('id')
            ->on('carpetas')
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
        Schema::dropIfExists('tareas');
    }
}
