<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodigosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_identificador','20');
            $table->string('contenido','200');
            $table->integer('id_biblioteca')->unsigned()->nullable();
            $table->integer('id_usocodigo')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('id_biblioteca')
            ->references('id')->on('bibliotecas')
            ->onDelete('cascade');
            $table->foreign('id_usocodigo')
            ->references('id')->on('usocodigos')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codigos');
    }
}
