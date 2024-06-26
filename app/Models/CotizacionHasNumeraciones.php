<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionHasNumeraciones extends Model
{
    use HasFactory;

    protected $table = 'cotizacion_has_numeraciones';

    protected $fillable = [
        'idCotizacion',
        'idNumeracion',
        'cantidad',
    ];
    
}
