<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenciasFecha extends Model
{
    protected $table = 'asistencias_fecha';

    const ESTADO_PENDIENTE = '0';
    const ESTADO_COMPLETADO = '1';
    const ESTADO_CANCELADO = '2';

    protected $fillable = [
        'fecha',
        'estado',
    ];

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'asistencias_fecha_id');
    }


}
