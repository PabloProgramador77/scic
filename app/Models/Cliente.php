<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [

        'numero',
        'nombre',
        'telefono',
        'estado',
        'ciudad',
        'email',
        'empresa',
        'razon',
        'rfc',
        'colonia',
        'calle',
        'exterior',
        'cp',

    ];
}
