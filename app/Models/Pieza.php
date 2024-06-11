<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pieza extends Model
{
    use HasFactory;

    protected $table = 'piezas';

    protected $fillable = [

        'nombre', 
        'alto', 
        'largo',
        'descripcion',
        'idModelo', 
        'cantidad',

    ];

    public function modelo(){

        return $this->hasOne( Modelo::class, 'id', 'idModelo' );
        
    }

    public function materiales ( $idCotizacion ){

        return $this->belongsToMany( Material::class, 'cotizacion_has_piezas', 'idPieza', 'idMaterial')
                    ->withPivot('idCotizacion')
                    ->wherePivot('idCotizacion', '=', $idCotizacion);

    }

}
