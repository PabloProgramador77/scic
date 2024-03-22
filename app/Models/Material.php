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

    ];

    public function proveedores(){

        return $this->belongsToMany( Proveedor::class, 'proveedor_has_materiales', 'idMaterial', 'idProveedor' );

    }

}
