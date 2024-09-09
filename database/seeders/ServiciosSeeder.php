<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

use App\Models\Servicio;
use App\Models\ServiciosCategorias;
class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rs =  ServiciosCategorias::where('name', '=', 'Belleza Facial')->first();
        Servicio::create([ 'name'=> 'Diseño de Cejas', 'codigo' => '201', 'categoria_id' => $rs->id, 'costo' => 2000, 'precio' => 10000, 'iva' => 10, 'tipo' => 'servicio', 'created_at'=> now(), 'created_by'=> 1]);
        Servicio::create([ 'name'=> 'Depilación Facial', 'codigo' => '202', 'categoria_id' => $rs->id, 'costo' => 2000, 'precio' => 10000, 'iva' => 10, 'tipo' => 'servicio', 'created_at'=> now(), 'created_by'=> 1]);
        Servicio::create([ 'name'=> 'Pigmentación', 'codigo' => '203', 'categoria_id' => $rs->id, 'costo' => 2000, 'precio' => 10000, 'iva' => 10, 'tipo' => 'servicio', 'created_at'=> now(), 'created_by'=> 1]);
        Servicio::create([ 'name'=> 'Henna', 'codigo' => '204', 'categoria_id' => $rs->id, 'costo' => 2000, 'precio' => 10000, 'iva' => 10, 'tipo' => 'servicio', 'created_at'=> now(), 'created_by'=> 1]);

    }
}
