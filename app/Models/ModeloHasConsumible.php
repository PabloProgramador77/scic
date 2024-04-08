<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloHasConsumible extends Model
{
    use HasFactory;

    protected $table = 'modelo_has_consumibles';

    protected $fillable = [

        'idModelo',
        'idConsumible',

    ];
}
