<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';

    protected $fillable = [
        'grupo_miembro_id',
        'asistio',
        'mensaje',
        'asistencias_fecha_id',
    ];

    protected $casts = [
        'asistio' => 'boolean',
    ];

    public function miembroGrupo()
    {
        return $this->belongsTo(MiembrosGrupo::class, 'grupo_miembro_id');
    }

    public function asistenciaFecha()
    {
        return $this->belongsTo(AsistenciasFecha::class, 'asistencias_fecha_id');
    }

}
