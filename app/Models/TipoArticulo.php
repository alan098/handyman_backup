<?php

namespace App\Models;


class TipoArticulo
{

    public static function all(){
        $tipos = Array('servicio', 'producto', 'combo');
        return $tipos;
    }

}
