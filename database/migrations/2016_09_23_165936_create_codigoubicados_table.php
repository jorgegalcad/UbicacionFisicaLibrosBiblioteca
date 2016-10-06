<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodigoubicadosTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('codigoubicados', function (Blueprint $table) {
      $table->increments('id');
      $table->float('coorX');
      $table->float('coorY');
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
    Schema::dropIfExists('codigoubicados');
  }
}
