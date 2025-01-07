<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;

    protected $table = 'procesos';

    protected $fillable = [
        'nombre', 
        'descripcion', 
        'orden'
    ];

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'idProceso', 'id');
    }
}
