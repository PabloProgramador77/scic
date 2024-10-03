<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suaje extends Model
{
    use HasFactory;

    protected $table = 'suajes';

    protected $fillable = [

        'nombre',
        'numero',
        'descripcion',

    ];
}
