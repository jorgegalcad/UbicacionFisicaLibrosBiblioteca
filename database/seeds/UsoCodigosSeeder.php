<?php

use Illuminate\Database\Seeder;

class UsoCodigosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('usocodigos')->insert([
        'nombre'=>'Identificación Biblioteca',
        'created_at'=>date("Y-m-d H:i:s"),
        'updated_at'=>date("Y-m-d H:i:s")
        ]);
        DB::table('usocodigos')->insert([
          'nombre'=>'Ubicación en Biblioteca',
          'created_at'=>date("Y-m-d H:i:s"),
          'updated_at'=>date("Y-m-d H:i:s")
          ]);
    }
}
