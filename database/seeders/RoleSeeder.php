<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // https://spatie.be/docs/laravel-permission/v5/basic-usage/basic-usage




        $admin = Role::create(['name' => 'admin']);
        $caja = Role::create(['name' => 'caja']);
        $cola = Role::create(['name' => 'colaborador']);

        Permission::create(['name' => 'admin.home', 'description' => 'Inicio'])->syncRoles([$admin, $caja, $cola]);



        /* Sistema */
        //Calendarios
        Permission::create(['name' => 'admin.calendar.index', 'description' => 'Eventos :: Ver Eventos'])->syncRoles([$admin, $cola]);
        Permission::create(['name' => 'admin.calendar.store', 'description' => 'Eventos :: Agregar Eventos'])->syncRoles([$admin, $cola]);
        Permission::create(['name' => 'admin.calendar.edit', 'description' => 'Eventos :: Modificar Eventos'])->syncRoles([$admin, $cola]);
        Permission::create(['name' => 'admin.calendar.destroy', 'description' => 'Eventos :: Eliminar Eventos'])->syncRoles([$admin, $cola]);

        //Calendarios
        Permission::create(['name' => 'admin.calendario.colaboradores.index', 'description' => 'Eventos :: Ver Eventos'])->syncRoles([$admin, $cola]);
        Permission::create(['name' => 'admin.calendario.colaboradores.store', 'description' => 'Eventos :: Agregar Eventos'])->syncRoles([$admin, $cola]);
        Permission::create(['name' => 'admin.calendario.colaboradores.edit', 'description' => 'Eventos :: Modificar Eventos'])->syncRoles([$admin, $cola]);
        Permission::create(['name' => 'admin.calendario.colaboradores.destroy', 'description' => 'Eventos :: Eliminar Eventos'])->syncRoles([$admin, $cola]);


        /*Mantenimientos*/
        //Users
        Permission::create(['name' => 'admin.users.index', 'description' => 'Usuarios :: Ver Usuarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.store', 'description' => 'Usuarios :: Agregar Usuarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.edit', 'description' => 'Usuarios :: Editar Usuarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.destroy', 'description' => 'Usuarios :: Eliminar Usuarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.showroles', 'description' => 'Usuarios :: Listar Permisos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.syncroles', 'description' => 'Usuarios :: Modificar Permisos'])->syncRoles([$admin]);
        //Roles
        Permission::create(['name' => 'admin.roles.index', 'description' => 'Roles :: Listar Roles'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.roles.store', 'description' => 'Roles :: Agregar Roles'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.roles.edit', 'description' => 'Roles :: Editar Roles'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.roles.destroy', 'description' => 'Roles :: Eliminar Roles'])->syncRoles([$admin]);
        //Entidades
        Permission::create(['name' => 'admin.entidades.index', 'description' => 'Entidades :: Ver Entidades'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.entidades.store', 'description' => 'Entidades :: Agregar Entidades'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.entidades.edit', 'description' => 'Entidades :: Modificar Entidades'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.entidades.destroy', 'description' => 'Entidades :: Eliminar Entidades'])->syncRoles([$admin]);
        //Sucursales
        Permission::create(['name' => 'admin.sucursales.index', 'description' => 'Sucursales :: Ver Sucursales'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.sucursales.store', 'description' => 'Sucursales :: Agregar Sucursales'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.sucursales.edit', 'description' => 'Sucursales :: Modificar Sucursales'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.sucursales.destroy', 'description' => 'Sucursales :: Eliminar Sucursales'])->syncRoles([$admin]);
        //Sucursales
        Permission::create(['name' => 'admin.depositos.index', 'description' => 'Depositos :: Ver Depositos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.depositos.store', 'description' => 'Depositos :: Agregar Depositos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.depositos.edit', 'description' => 'Depositos :: Modificar Depositos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.depositos.destroy', 'description' => 'Depositos :: Eliminar Depositos'])->syncRoles([$admin]);

        //Personas
        Permission::create(['name' => 'admin.personas.index', 'description' => 'Personas :: Ver Personas'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.personas.store', 'description' => 'Personas :: Agregar Personas'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.personas.edit', 'description' => 'Personas :: Modificar Personas'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.personas.destroy', 'description' => 'Personas :: Eliminar Personas'])->syncRoles([$admin]);

         //Articulos Categorias
         Permission::create(['name' => 'admin.categorias_productos.index', 'description' => 'Categorias de Productos :: Ver Categorias'])->syncRoles([$admin]);
         Permission::create(['name' => 'admin.categorias_productos.store', 'description' => 'Categorias de Productos :: Agregar Categorias'])->syncRoles([$admin]);
         Permission::create(['name' => 'admin.categorias_productos.edit', 'description' => 'Categorias de Productos :: Modificar Categorias'])->syncRoles([$admin]);
         Permission::create(['name' => 'admin.categorias_productos.destroy', 'description' => 'Categorias de Productos :: Eliminar Categorias'])->syncRoles([$admin]);

         //Servicios Categorias
         Permission::create(['name' => 'admin.categorias_servicios.index', 'description' => 'Categorias de Servicios :: Ver Categorias'])->syncRoles([$admin]);
         Permission::create(['name' => 'admin.categorias_servicios.store', 'description' => 'Categorias de Servicios :: Agregar Categorias'])->syncRoles([$admin]);
         Permission::create(['name' => 'admin.categorias_servicios.edit', 'description' => 'Categorias de Servicios :: Modificar Categorias'])->syncRoles([$admin]);
         Permission::create(['name' => 'admin.categorias_servicios.destroy', 'description' => 'Categorias de Servicios :: Eliminar Categorias'])->syncRoles([$admin]);

        //Productos
        Permission::create(['name' => 'admin.productos.index', 'description' => 'Productos :: Ver Productos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.productos.store', 'description' => 'Productos :: Agregar Productos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.productos.edit', 'description' => 'Productos :: Modificar Productos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.productos.destroy', 'description' => 'Productos :: Eliminar Productos'])->syncRoles([$admin]);

        //Servicios
        Permission::create(['name' => 'admin.servicios.index', 'description' => 'Servicios :: Ver Servicios'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.servicios.store', 'description' => 'Servicios :: Agregar Servicios'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.servicios.edit', 'description' => 'Servicios :: Modificar Servicios'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.servicios.destroy', 'description' => 'Servicios :: Eliminar Servicios'])->syncRoles([$admin]);

        //Combos
        Permission::create(['name' => 'admin.combos.index', 'description' => 'Combos :: Ver Combos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.combos.store', 'description' => 'Combos :: Agregar Combos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.combos.edit', 'description' => 'Combos :: Modificar Combos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.combos.destroy', 'description' => 'Combos :: Eliminar Combos'])->syncRoles([$admin]);

        //Promos
        Permission::create(['name' => 'admin.promos.index', 'description' => 'Promos :: Ver Promos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.promos.store', 'description' => 'Promos :: Agregar Promos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.promos.edit', 'description' => 'Promos :: Modificar Promos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.combpromosos.destroy', 'description' => 'Promos :: Eliminar Promos'])->syncRoles([$admin]);
        //cuentas
        Permission::create(['name' => 'admin.cuentas.index', 'description' => 'Ventas :: Ver ventas'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cuentas.store', 'description' => 'Ventas :: Agregar ventas'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cuentas.edit', 'description' => 'Ventas :: Modificar ventas'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.cuentas.destroy', 'description' => 'Ventas :: Eliminar ventas'])->syncRoles([$admin]);
        //ventas
        Permission::create(['name' => 'admin.vender.index', 'description' => 'Promos :: Ver ventas'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.vender.store', 'description' => 'Promos :: Agregar ventas'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.vender.edit', 'description' => 'Promos :: Modificar ventas'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.vender.destroy', 'description' => 'Promos :: Eliminar ventas'])->syncRoles([$admin]);

        //gastos
        Permission::create(['name' => 'admin.gastos.index', 'description' => 'Gastos :: Listar gastos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.gastos.store', 'description' => 'Gastos :: Agregar gastos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.gastos.edit', 'description' => 'Gastos :: Modificar gastos'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.gastos.destroy', 'description' => 'Gastos :: Eliminar gastos'])->syncRoles([$admin]);

        //timbrados
        Permission::create(['name' => 'admin.timbrados.index', 'description' => 'Roles :: listar Timbrados'])->syncRoles([$admin]);
        
        //compras
        Permission::create(['name' => 'admin.compras.index', 'description' => 'Compras :: Listar Compras'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.compras.store', 'description' => 'Compras :: Agregar Compras'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.compras.edit', 'description' => 'Compras :: Modificar Compras'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.compras.destroy', 'description' => 'Compras :: Eliminar Compras'])->syncRoles([$admin]);

        //inventarios
        Permission::create(['name' => 'admin.inventarios.index', 'description' => 'Inventarios :: Listar Inventarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.inventarios.store', 'description' => 'Inventarios :: Agregar Inventarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.inventarios.edit', 'description' => 'Inventarios :: Modificar Inventarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.inventarios.destroy', 'description' => 'Inventarios :: Eliminar Inventarios'])->syncRoles([$admin]);





        //sucursal cambio
        Permission::create(['name' => 'admin.configuracion.sucursal', 'description' => 'Cambio :: Entidad , Sucursal'])->syncRoles([$admin]);
    }
}
