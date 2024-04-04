<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloHasCosto extends Model
{
    use HasFactory;

    protected $table = 'modelo_has_costos';

    protected $fillable = [

        'idModelo',
        'idCosto',

    ];
}
