<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $table = 'modelos';

    protected $fillable = [

        'nombre', 
        'numero', 
        'descripcion',

    ];

    public function numeraciones(){

        return $this->belongsToMany( Numeracion::class, 'modelo_has_numeraciones', 'idModelo', 'idNumeracion' );
        
    }

}
