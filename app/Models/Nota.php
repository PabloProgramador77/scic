<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = 'notas';

    protected $fillable = [

        'idCliente', 
        'pares', 
        'total', 
        'estado',

    ];

    public function cliente(){

        return $this->hasOne( Cliente::class, 'id', 'idCliente' );
        
    }

    public function cotizaciones(){

        return $this->belongsToMany( Cotizacion::class, 'nota_has_cotizaciones', 'idNota', 'idCotizacion' );
        
    }
}
