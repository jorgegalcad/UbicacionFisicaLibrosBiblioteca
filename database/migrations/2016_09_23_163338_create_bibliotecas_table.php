<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBibliotecasTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('bibliotecas', function (Blueprint $table) {
      $table->increments('id');
      $table->string('nombre','80');
      $table->string('pais','20');
      $table->string('departamentto','20');
      $table->string('municipio','20');
      $table->string('direccion','30');
      $table->integer('id_user')->unsigned()->nullable();
      $table->timestamps();
      $table->foreign('id_user')
      ->references('id')->on('users')
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
    Schema::dropIfExists('bibliotecas');
  }
}
