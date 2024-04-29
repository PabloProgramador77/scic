<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = 'notas';

    protected $fillable = [

        'idCliente', 'pares', 'total'

    ];

    public function cliente(){

        return $this->hasOne( Cliente::class, 'id', 'idCliente' );
        
    }
}
