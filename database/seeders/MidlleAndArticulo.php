<?php

namespace Database\Seeders;

use App\Models\Articulo;
use App\Models\ArticulosCategorias as ModelsArticulosCategorias;
use ArticulosCategorias;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class MidlleAndArticulo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creamos el articulo y los middleware faltantes
        $pro1 = ModelsArticulosCategorias::create([ 'name'=> 'giftcard', 'created_at'=> now(), 'created_by'=> 1, 'tipo' => 'producto' ]);
        $rs =  ModelsArticulosCategorias::where('name', '=', 'giftcard')->first();
        Articulo::create([ 'name'=> 'Gitfcard', 'codigo' => '001', 'categoria_id' => $rs->id, 'costo' => 0, 'precio' => 0, 'iva' => 10, 'tipo' => 'producto', 'created_at'=> now(), 'created_by'=> 1]);


        $admin = Role::where('name','admin')->first();
        
        #dias libres
        Permission::create(['name' => 'admin.diaslibres.index', 'description' => 'Dias libres ::Ver'])->syncRoles([$admin]);
        #recordatorios#
        Permission::create(['name' => 'admin.recordatorios.index', 'description' => 'recordatorios  :: para llamar a las personas '])->syncRoles([$admin]);
        #giftcard
        Permission::create(['name' => 'admin.giftcard.index', 'description' => 'giftcard ::Ver crear etc'])->syncRoles([$admin]);

        #creamos la seccion de gastos conceptos y demas 
        $CC = DB::table('tipo_comprobante')->insert([ 'name'=> 'liquidacion de salario', 'created_at'=> now(), 'created_by'=> 1]);

        $CC = DB::table('comprobantes_conceptos')->insert([ 'name'=> 'pago liquidacion de  salario', 'created_at'=> now(), 'created_by'=> 1]);

        


    }
}
