<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruta extends Model
{
    use HasFactory;

    protected $fillable = [
        'origen',
        'destino',
        'duracion',
        'fechaSalida',
        'horaSalida',
        'cooperativa_id',
    ];

    public function cooperativa(){
        return $this->belongsTo(Cooperativa::class);
    }

    public function reservas(){
        return $this->hasMany(Reserva::class);
    }
}
