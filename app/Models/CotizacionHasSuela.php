<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionHasSuela extends Model
{
    use HasFactory;

    protected $table = 'cotizacion_has_suelas';

    protected $fillable = [

        'idCotizacion',
        'idSuela',

    ];

    public function suelas(){

        return $this->belongsToMany( Suela::class, 'cotizacion_has_suelas', 'idCotizacion', 'idSuela' );
        
    }
}
