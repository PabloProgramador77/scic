<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloHasCoste extends Model
{
    use HasFactory;

    protected $table = 'modelo_has_costes';

    protected $fillable = [
        
        'idModelo',
        'idCoste',

    ];
}
