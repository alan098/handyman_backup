<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepositoAddSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suc =DB::table('sucursales')->get();
        foreach ($suc as  $value) {
            DB::table('depositos')->insert([
                'name'=>'Mesa Trabajo',
                'entidad_id'=>1,
                'sucursal_id'=>$value->id,
                'created_by'=>1,
                'created_at'=>now(),
            ]);
            DB::table('depositos')->insert([
                'name'=>'Vitrina',
                'entidad_id'=>1,
                'sucursal_id'=>$value->id,
                'created_by'=>1,
                'created_at'=>now(),
            ]);
        }
        DB::unprepared('update depositos set es_real =true where id < 6');
        DB::unprepared("
            --primero eliminamos 
            alter table articulos drop CONSTRAINT articulos_tipo_check;
            --luego agregamos insumo
            alter table articulos 
            add constraint articulos_tipo_check check (tipo in ('producto','servicio','combo','insumo'));
        ");
        DB::unprepared("alter table ops alter column comprobante_id drop not null;");
    }
}
