<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasPieza extends Model
{
    use HasFactory;

    protected $table = 'model_has_piezas';

    protected $fillable = [
        
        'idModelo', 'idPieza', 'cantidad',

    ];
}
