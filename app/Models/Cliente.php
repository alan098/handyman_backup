<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = ['id', 'created_at', 'created_by'];
    
    public function persona(){
        return $this->belongsTo(Persona::class, 'id', 'id');
    }


}
