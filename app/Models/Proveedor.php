<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [

        'nombre', 'telefono', 'direccion'

    ];

    public function materiales(){

        return $this->belongsToMany( Material::class, 'proveedor_has_materiales', 'idProveedor', 'idMaterial' );
        
    }
}
