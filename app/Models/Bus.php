<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bus extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'placa',
        'cantidad_asientos',
        'cooperativa_id',
    ];

    public function cooperativa(){
        return $this->belongsTo(Cooperativa::class);
    }
    public function rutas(){
        return $this->hasMany(Ruta::class);
    }
    public function reservas(){
        return $this->hasMany(Reserva::class);
    }
}
