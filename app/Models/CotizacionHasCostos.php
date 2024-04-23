<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionHasCostos extends Model
{
    use HasFactory;

    protected $table = 'cotizacion_has_costos';

    protected $fillable = [

        'idCotizacion',
        'idCosto',

    ];

    public function costos(){

        return $this->belongsToMany( Costo::class, 'cotizacion_has_costo', 'idCosto', 'idModelo' );
        
    }
}
