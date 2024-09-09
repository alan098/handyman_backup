<?php

namespace Database\Seeders;

use App\Models\PlanCuenta;
use Illuminate\Database\Seeder;

class PlanCuentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlanCuenta::truncate();
        $filename = ('./public/migraciones/plan_cuentas.csv');
        foreach (file($filename) as $line) {
            $cta = explode(',', $line);
            $cta = PlanCuenta::create(
                [
                    'numero' => trim($cta[1]),
                    'name' => trim($cta[2]),
                    'nivel' => trim($cta[3]),
                    'asentable' => trim($cta[4]),
                    'padre' => (trim($cta[5]) == 'NULL') ? null : trim($cta[5]),
                    'created_by' => 1,
                ]
            );
        }



    }
}
