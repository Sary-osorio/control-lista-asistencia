<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiembrosGrupo extends Model
{
    protected $table = 'grupos_miembros';

    protected $fillable = [
        'miembro_id',
        'grupo_id',
    ];

    public function miembro()
    {
        return $this->belongsTo(Miembro::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupos::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'grupo_miembro_id');
    }
}
