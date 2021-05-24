<?php

use Database\Seeders\TablaCuentaContable;
use Database\Seeders\TablaEstadoOtSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->truncateTablas([
            'rol',
            'permiso',
            'trabajador',
            'trabajador_rol'
        ]);
        $this->call(TablaRolSeeder::class);
        $this->call(TablaPermisoSeeder::class);
        $this->call(TrabajadorAdministradorSeeder::class);
        $this->call(TablaMenuSeeder::class);
        $this->call(TablaMenuRolSeeder::class);
        $this->call(TablaCargoTrabajadorSeeder::class);
        $this->call(TablaCategoriaProductoSeeder::class);
        $this->call(TablaEstadoConceptoPagoSeeder::class);
        $this->call(TablaEstadoFacturaSeeder::class);
        $this->call(TablaEstadoGastoSeeder::class);
        $this->call(TablaEstadoOtSeeder::class);
        $this->call(TablaTipoGastoSeeder::class);
        $this->call(TablaTipoProductoSeeder::class);
        $this->call(TablaCuentaContable::class);
    }
    protected function truncateTablas(array $tablas){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach($tablas as $tabla){
            DB::table($tabla)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS =1;');
    }
}
