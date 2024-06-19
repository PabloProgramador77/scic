<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numeracion extends Model
{
    use HasFactory;

    protected $table = 'numeraciones';

    protected $fillable = [

        'numero',

    ];

    public function cotizaciones(){

        return $this->belongsToMany( Cotizacion::class, 'cotizacion_has_numeraciones', 'idNumeracion', 'idCotizacion' )->withPivot('cantidad');

    }

    public function cantidad( $idCotizacion, $idNumeracion ){

        $cantidad = $this->cotizaciones()->wherePivot('idCotizacion', $idCotizacion)->wherePivot('idNumeracion', $idNumeracion)->value('cantidad');

        return $cantidad;

    }

}
