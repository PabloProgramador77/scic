<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloHasSuela extends Model
{
    use HasFactory;

    protected $table = 'modelo_has_suelas';

    protected $fillable = [

        'idModelo',
        'idSuela',

    ];
}
