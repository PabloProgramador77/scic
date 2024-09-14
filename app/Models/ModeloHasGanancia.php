<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloHasGanancia extends Model
{
    use HasFactory;

    protected $table = 'modelo_has_ganancias';

    protected $fillable = [
        'ganancia',
    ];
}
