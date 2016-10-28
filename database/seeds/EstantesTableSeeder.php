<?php

use Illuminate\Database\Seeder;

class EstantesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<5;$i++)
        {
          DB::table('estantes')->insert([
            'coorX' => $i*20,
            'coorY' => $i*20,
            'ancho' => 10,
            'alto' => 10,
            'largo' => 10,
            'codigo' => '00'.$i,
            'id_plano' => '1',
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }
    }
}
