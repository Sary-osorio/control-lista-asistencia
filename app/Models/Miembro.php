<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Miembro extends Model
{
    protected $table = 'miembros';

    protected $fillable = [
        'nombre',
        'apellidos',
        'fecha_nac',
        'grupo_extra',
    ];

    protected $casts = [
        'grupo_extra' => 'string',
    ];

    public function getFullNameAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    public function getAgeAttribute()
    {
        return now()->diffInYears($this->fecha_nac);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
