<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';

    protected $fillable = [
        'grupo_miembro_id',
        'asistencias_fecha_id',
        'asistio'
    ];

    protected $casts = [
        'asistio' => 'boolean',
    ];

    public function miembroGrupo()
    {
        return $this->belongsTo(MiembrosGrupo::class, 'grupo_miembro_id');
    }

    public function fecha()
    {
        return $this->belongsTo(AsistenciasFecha::class, 'asistencias_fecha_id');
    }

    // public function getAsistioAttribute($value)
    // {
    //     return $value ? 'Si' : 'No';
    // }

    // public function getMensajeAttribute($value)
    // {
    //     return $value ? 'Si' : 'No';
    // }

}
