<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocenteMateriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docente_materia', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('materia_id');

            $table->timestamps();

            $table->foreign('user_id')
            ->references('user_id')
            ->on('docentes')
            ->onDelete('cascade')
            ->onDelete('cascade');

            $table->foreign('materia_id')
            ->references('id')
            ->on('materias')
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
        Schema::dropIfExists('docente_materia');
    }
}
