<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionHasPiezas extends Model
{
    use HasFactory;

    protected $table = 'cotizacion_has_piezas';

    protected $fillable = [

        'idCotizacion', 
        'idPieza',
        'idMaterial',

    ];

    public function piezas(){

        return $this->belongsToMany( Pieza::class, 'cotizacion_has_piezas', 'idPieza', 'idModelo' );

    }

}
