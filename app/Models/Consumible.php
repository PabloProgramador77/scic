<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumible extends Model
{
    use HasFactory;

    protected $table = 'consumibles';

    protected $fillable = [

        'nombre',
        'tipo',
        'precio',
        'descripcion',

    ];
}
