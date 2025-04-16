<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfils', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
            $table->string('apellido',100);
            $table->date('fecha_nac');
            $table->string('DNI',8)->unique();
            $table->string('edad',3);
            $table->enum('sexo', ['m','f']);
            $table->text('direccion');
            $table->text('distrito');
            $table->unsignedBigInteger('user_id');


            //RELACION DE  UNO A UNO DE  PERFIL CON USER
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfils');
    }
}
