<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Venta;
use App\Models\VentasDetalles;
use Illuminate\Database\Seeder;
// use Faker\Generator as Faker;


class VentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //limpiamos las tablas
        VentasDetalles::truncate();
        Venta::truncate();
        $faker = \Faker\Factory::create();
        $colaboradores = User::where('es_colaborador', true)->get();

        for($k=0; $k<100; $k++){

            $importes = [50000, 100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000, 550000, 600000, 650000, 700000, 750000, 800000, 850000, 900000, 950000, 1000000];
            $importe = $importes[rand(0, count($importes) - 1)];
            $total = $importe;
            $iva = round($total - ( $total / 1.1), 0);
            $cliente = rand(1, 103);
            $fecha = $faker->dateTimeBetween($startDate = date('Y-m-01'), $endDate = 'now');
            //creamos una venta
            $ven = Venta::create(
                ['fecha' => $fecha,
                'entidad_id' => 1,
                'entidad_id' => 1,
                'sucursal_id' => 1,
                'sucursal_id' => 1,
                'punto_de_venta_id' => 1,
                'importe' => $importe,
                'total' => $total,
                'iva' => $iva,
                'deposito_id' => 1,
                'saldo' => 0,
                'descuento' => 0,
                'anticipo' => 0,
                'gift_card' => 0,
                'concluido' => true,
                'cliente_id' => $cliente,
                'created_by' => 1,
                'created_at' => now(),]
            );

            // creamos 2 detalles de venta
            for($i=0; $i<2; $i++){
                $vd = VentasDetalles::create([
                    'venta_id' => $ven->id,
                    'articulo_id' => rand(1, 15),
                    'cantidad' => 1,
                    'precio_unitario' => round($importe / 2, 0),
                    'precio_total' => round($importe / 2, 0),
                    'excenta' => 0,
                    'gravada5' => 0,
                    'gravada10' => round($importe / 2, 0),
                    'importe_porcentaje' => 0,
                    'importe_descuento' => 0,
                    'created_at' => now(),
                    'created_by' => 1,
                    'colaborador_id' => $colaboradores[rand(0, 5)]->id
                ]);
            }

        }


    }
}
