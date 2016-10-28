<?php

use Illuminate\Database\Seeder;

class CodigosUbicadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::table('codigoubicados')->insert([
        'coorX' => 300,
        'coorY' => 300,
        'id_plano' => '1',
        'id_codigo'=>'1',
        'created_at'=>date("Y-m-d H:i:s"),
        'updated_at'=>date("Y-m-d H:i:s")
        ]);
    }
}
