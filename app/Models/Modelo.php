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

        return $this->belongsToMany( Numeracion::class, 'modelo_has_numeraciones', 'idModelo', 'idNumeracion' )->orderBy('numero', 'asc');
        
    }

    public function costos(){

        return $this->belongsToMany( Costo::class, 'modelo_has_costos', 'idModelo', 'idCosto' );

    }

    public function suelas(){

        return $this->belongsToMany( Suela::class, 'modelo_has_suelas', 'idModelo', 'idSuela' );

    }

    public function consumibles(){

        return $this->belongsToMany( Consumible::class, 'modelo_has_consumibles', 'idModelo', 'idConsumible' );
        
    }

}
