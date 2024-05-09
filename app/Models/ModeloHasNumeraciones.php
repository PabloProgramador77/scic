<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloHasNumeraciones extends Model
{
    use HasFactory;

    protected $table = 'modelo_has_numeraciones';

    protected $fillable = [

        'idModelo',
        'idNumeracion',

    ];

    public function modelo(){

        return $this->hasOne( Modelo::class, 'modelo_has_numeraciones', 'id', 'idModelo' );

    }

    
}
