<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materiales';

    protected $fillable = [

        'nombre', 
        'concepto', 
        'precio', 
        'unidades',
        'color',
        'hexColor',

    ];

    public function proveedores(){

        return $this->belongsToMany( Proveedor::class, 'proveedor_has_materiales', 'idMaterial', 'idProveedor' );

    }

    public function piezas(){

        return $this->belongsToMany( Pieza::class, 'cotizacion_has_piezas', 'idMaterial', 'idPieza');

    }

    public function pieza(){

        return $this->piezas()->first();


    }

    public function proveedor(){

        return $this->proveedores()->first();

    }

}
