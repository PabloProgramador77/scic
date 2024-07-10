<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorHasMateriales extends Model
{
    use HasFactory;

    protected $table = 'proveedor_has_materiales';

    protected $fillable = [

        'idProveedor', 'idMaterial'

    ];

    public function material(){

        return $this->belongsTo( Material::class, 'idMaterial' );

    }

    public function proveedor(){

        return $this->belongsTo( Proveedor::class, 'idProveedor' );
        
    }
}
