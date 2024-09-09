<?php

namespace Database\Seeders;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call( RoleSeeder::class); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( UserSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( EntidadesSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( CategoriasSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( ProductosSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( ServiciosSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( CombosSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( EstadosSedeer::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( ClientesSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( ProveedoresSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( PlanCuentasSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( CentrosCostosSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( BancosTarjetas::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( CuentasBancosSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // //demo timbrado
        // $this->call( TimbradosSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // //solo para demo!
        // $this->call( VentasSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        // $this->call( GastosSeeder::class ); #ya se ejecutaron  fecha=0/0/2022
        //$this->updateUser(); #ya se ejecutaron  fecha=0/0/2022

        $this->call(DescuentosCSeeder::class ); #ya se ejecutaron  fecha=30/08/2022
        $this->call(MidlleAndArticulo::class );#ya se ejecutaron  fecha=30/08/2022
    }

    public function updateUser(){
        DB::table('users')
        ->update(['password' => bcrypt('secret'), 'entidad_id'=>1, 'sucursal_id'=>1 ,'deposito_id'=>1]);

        DB::table('articulos')
        ->where('tipo','servicio')
        ->update(['articulos.end' => '00:30']);
        //personas de muestra
    }




}
