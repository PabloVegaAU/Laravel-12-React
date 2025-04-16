<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Constraint\SameSize;

class CreateLogrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->enum('tipo',[0,1,2,3,4,5]);
            $table->integer('exp_req')->nullable();
            /*
                0 = basico
                1 = regular
                2 = normal
                3 = bueno
                4 = muy bueno
                5 = excelente
            */

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
        Schema::dropIfExists('logros');
    }
}
