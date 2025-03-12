<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = 'notas';

    protected $fillable = [

        'numero',
        'idCliente', 
        'pares', 
        'total', 
        'estado',
        'iva',
        'envio',
        'fecha_entrega',

    ];

    public function cliente(){

        return $this->hasOne( Cliente::class, 'id', 'idCliente' );
        
    }

    public function cotizaciones(){

        return $this->belongsToMany( Cotizacion::class, 'nota_has_cotizaciones', 'idNota', 'idCotizacion' );
        
    }

    public function pares( $idNota, $idCotizacion ){

        return $this->cotizaciones()->wherePivot('idCotizacion', $idCotizacion)->wherePivot('idNota', $idNota)->value('totalPares');

    }

    public function monto( $idNota, $idCotizacion ){

        return $this->cotizaciones()->wherePivot('idCotizacion', $idCotizacion)->wherePivot('idNota', $idNota)->value('monto');

    }

    public function descuento( $idNota, $idCotizacion ){

        return $this->cotizaciones()->wherePivot('idCotizacion', $idCotizacion)->wherePivot('idNota', $idNota)->value('descuento');
        
    }
}
