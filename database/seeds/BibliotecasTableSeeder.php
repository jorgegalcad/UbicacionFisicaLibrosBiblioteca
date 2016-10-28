<?php

use Illuminate\Database\Seeder;

class BibliotecasTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    DB::table('bibliotecas')->insert([
      'nombre' => 'Alfonso Borrero Cabal',
      'pais' => 'Colombia',
      'departamento' => 'Caldas',
      'municipio' =>'Manizales',
      'direccion' => 'Cra. 9 19-03',
      'id_user' => '1',
      'created_at'=>date("Y-m-d H:i:s"),
      'updated_at'=>date("Y-m-d H:i:s")
      ]);
    }
  }
