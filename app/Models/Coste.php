<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coste extends Model
{
    use HasFactory;

    protected $table = 'costes';
    
    protected $fillable = [

        'nombre',
        'monto',
        'descripcion',

    ];
}
