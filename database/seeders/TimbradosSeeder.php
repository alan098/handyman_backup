<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimbradosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->timbrado();
        $this->puntoVenta();
        $this->timbradoPv();

    
    }
    public function puntoVenta(){
    Log::info(__FUNCTION__.'/'.__FILE__); 
     try { 
        $data[] = Array(
            'name' => "caja1",
            "entidad_id"=>1,
            "sucursal_id"=>1,
            'created_at' => 'now()', 
            'created_by' => 1
        );
        DB::table('puntos_de_ventas')->insert($data);
        unset($data);
     } catch (\Throwable $th) {
     Log::error('Error'.$th->getMessage());
     }
    }
    public function timbradoPv(){
    Log::info(__FUNCTION__.'/'.__FILE__);
     try { 
        $data[] = Array(
            'timbrado_id' => 1, 
            'punto_de_venta_id' => 1, 
            'entidad_id' => 1,
            'sucursal_id' => 1,
            'factura_desde' => 1, 
            'factura_hasta' => 1000,
            "factura_actual"=>0,
            'created_at' => 'now()',
            'created_by' =>1
        );                      
        DB::table('timbrados_sucursal_pv')->insert($data);
     } catch (\Throwable $th) {
     Log::error('Error'.$th->getMessage());
     }
    }
    public function timbrado(){
    Log::info(__FUNCTION__.'/'.__FILE__); 
     try { 
        $fecha = date('Y-m-d');
        $proximoAnho = strtotime ( '+1 year' , strtotime ( $fecha ) ) ;
        $proximoAnho = date ( 'Y-m-d' , $proximoAnho );
        $data[] = Array(
            'entidad_id' => 1, 
            'numero_timbrado' => '12345678', 
            'es_activo' => 'true', 
            'fecha_ini_vigencia' => 'now()', 
            'fecha_fin_vigencia' => $proximoAnho,  
            'tipo_factura'=>'fc',
            'created_at' => 'now()',
            'created_by' =>1
        );                     

        DB::table('timbrados')->insert($data);
     } catch (\Throwable $th) {
     Log::error('Error'.$th->getMessage());
     }
    }
}
