<?php

use Illuminate\Database\Seeder;

class CodigosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('codigos')->insert([
        'id_biblioteca' => '1',
        'serial_identificador'=>'abc123',
        'contenido'=>'Entrada de la Biblioteca alfonso borrero cabal',
        'id_biblioteca'=>'1',
        'id_usocodigo'=>'1',
        'created_at'=>date("Y-m-d H:i:s"),
        'updated_at'=>date("Y-m-d H:i:s")
        ]);
    }
}
