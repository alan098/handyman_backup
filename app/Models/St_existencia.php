<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class St_existencia extends Model
{
    use HasFactory;
    protected $table = 'st_existencia';

    public function Articulo()
    {
        return $this->belongsTo(Articulo::class);
    }

}
