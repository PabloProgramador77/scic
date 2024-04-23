<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionHasConsumible extends Model
{
    use HasFactory;

    protected $table = 'cotizacion_has_consumibles';

    protected $fillable = [

        'idCotizacion',
        'idConsumible',

    ];

    public function consumibles(){

        return $this->belongsToMany( Consumible::class, 'cotizacion_has_consumibles', 'idCotizacion', 'idConsumible' );
        
    }
}
