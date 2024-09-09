<?php

namespace App\Models;


class Dias
{

    public static function allTrue(){
        $dias = Array('lunes' => true, 'martes' => true, 'miercoles' => true, 'jueves' => true, 'viernes' => true, 'sabados' => true);
        return $dias;
    }

    public static function allFalse(){
        $dias = Array('lunes' => false, 'martes' => false, 'miercoles' => false, 'jueves' => false, 'viernes' => false, 'sabados' => false);
        return $dias;
    }



}
