<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaHasCotizacion extends Model
{
    use HasFactory;

    protected $table = 'nota_has_cotizaciones';

    protected $fillable = [

        'idNota',
        'idCotizacion',
        'totalPares',
        'monto',
        'descuento',

    ];

    public function nota(){

        return $this->hasOne( Nota::class,  'nota_has_cotizaciones', 'id', 'idNota' );

    }

    public function cotizaciones(){

        return $this->belongsToMany( Cotizacion::class, 'nota_has_cotizaciones', 'id', 'idCotizacion' );

    }

    
}
