<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';

    protected $fillable = [
        'miembro_id',
        'fecha',
        'asistio',
        'mensaje',
    ];

    public function miembro()
    {
        return $this->belongsTo(Miembro::class);
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
