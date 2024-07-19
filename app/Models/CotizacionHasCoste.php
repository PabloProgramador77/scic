<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionHasCoste extends Model
{
    use HasFactory;

    protected $table = 'cotizacion_has_costes';

    protected $fillable = [

        'idCotizacion', 'idCoste',

    ];

    public function costes(){

        return $this->belongsToMany( Coste::class, 'cotizacion_has_costes', 'idCoste', 'idModelo' );
        
    }
}
