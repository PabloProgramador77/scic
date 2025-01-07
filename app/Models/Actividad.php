<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'orden',
        'tipo',
        'duracion',
        'idProceso',
        'idUsuario',
    ];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'idProceso');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }
}
