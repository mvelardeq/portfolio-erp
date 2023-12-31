<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoConceptoPagoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('estado_conceptopago')->delete();

        \DB::table('estado_conceptopago')->insert([
            'id' => 1,
            'nombre' => 'Sin facturar',
            'created_at' => '2022-07-23 08:54:03',
            'updated_at' => '2022-07-23 08:54:03',
        ]);
        \DB::table('estado_conceptopago')->insert([
            'id' => 2,
            'nombre' => 'Facturado',
            'created_at' => '2022-07-23 08:54:03',
            'updated_at' => '2022-07-23 08:54:03',
        ]);
        \DB::table('estado_conceptopago')->insert([
            'id' => 3,
            'nombre' => 'Pagado',
            'created_at' => '2022-07-23 08:54:03',
            'updated_at' => '2022-07-23 08:54:03',
        ]);
    }
}
