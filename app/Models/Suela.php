<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suela extends Model
{
    use HasFactory;

    protected $table = 'suelas';

    protected $fillable = [

        'nombre', 
        'precio',
        'descripcion'

    ];
}
