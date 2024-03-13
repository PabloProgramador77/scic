<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pieza extends Model
{
    use HasFactory;

    protected $table = 'piezas';

    protected $fillable = [

        'nombre', 'alto', 'largo',
        'descripcion', 'area', 'cm2', 
        'dm2', 'mts'

    ];

    public function modelo(){

        return $this->belongsToMany( Modelo::class, 'model_has_piezas', 'idPieza', 'idModelo' );
        
    }
}
