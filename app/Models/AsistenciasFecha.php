<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenciasFecha extends Model
{
    protected $table = 'asistencias_fecha';

    protected $fillable = [
        'fecha',
        'estado',
    ];

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'asistencias_fecha_id');
    }
}
