<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    protected $table = 'grupos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
