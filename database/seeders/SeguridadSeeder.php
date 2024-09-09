<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeguridadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name','admin')->first();
        //*roles generales para acceso nomas
        //reporte ventas
        Permission::create(['name' => 'admin.reportes.ventas.index', 'description' => 'Reportes :: Ventas'])->syncRoles([$admin]);
        //pago comision
        Permission::create(['name' => 'admin.pagos.comisiones.index', 'description' => 'Pagos ::Comisiones'])->syncRoles([$admin]);
        #descuentos
        Permission::create(['name' => 'admin.descuentos.index', 'description' => 'Pagos :: Realizar Descuentos'])->syncRoles([$admin]);
        //ventas
        Permission::create(['name' => 'admin.ventaaas.index', 'description' => 'ventas :: Vender'])->syncRoles([$admin]);
        #ingresos
        Permission::create(['name' => 'admin.ingresos.index', 'description' => 'Reportes :: ingresos'])->syncRoles([$admin]);
        //transferencias
        Permission::create(['name' => 'admin.transfer.index', 'description' => 'Transferencias :: generar Transferencias'])->syncRoles([$admin]);
        #ordenes insumos
        Permission::create(['name' => 'admin.ordinsus.index', 'description' => 'insumos :: ordernes de insumo'])->syncRoles([$admin]);
        #insumos
        Permission::create(['name' => 'admin.insumos.index', 'description' => 'insumos :: Listar/crear/editar/eliminar'])->syncRoles([$admin]);
        
    }
}
