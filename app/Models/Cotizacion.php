<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';

    protected $fillable = [
        
        'precio',
        'estado',
        'idModelo',
        'idCliente',

    ];

    public function modelo(){

        return $this->hasOne( Modelo::class, 'id', 'idModelo' );
        
    }

    public function cliente(){

        return $this->hasOne( Cliente::class, 'id', 'idCliente' );
        
    }

    public function numeraciones(){

        return $this->belongsToMany( Numeracion::class, 'cotizacion_has_numeraciones', 'idCotizacion', 'idNumeracion' )->withPivot('cantidad');
    
    }

    public function piezas(){

        return $this->belongsToMany( Pieza::class, 'cotizacion_has_piezas', 'idCotizacion', 'idPieza' )->withPivot('idMaterial');

    }

}
