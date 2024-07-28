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

    public function consumibles(){

        return $this->belongsToMany( Consumible::class, 'cotizacion_has_consumibles', 'idCotizacion', 'idConsumible' );

    }

    public function suelas(){

        return $this->belongsToMany( Suela::class, 'cotizacion_has_suelas', 'idCotizacion', 'idSuela' );
        
    }

    public function colores(){

        return $this->belongsToMany( Material::class, 'cotizacion_has_piezas', 'idCotizacion', 'idMaterial')->withPivot('colorMaterial');

    }

}
