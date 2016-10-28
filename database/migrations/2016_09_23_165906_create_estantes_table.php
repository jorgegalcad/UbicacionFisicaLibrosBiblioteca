<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estantes', function (Blueprint $table) {
            $table->increments('id');
            $table->float('coorX');
            $table->float('coorY');
            $table->float('ancho');
            $table->float('alto');
            $table->float('largo');
            $table->string('codigo');
            $table->integer('id_plano')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('id_plano')
            ->references('id')->on('planos')
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
        Schema::dropIfExists('estantes');
    }
}
