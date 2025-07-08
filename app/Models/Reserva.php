<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_reserva',
        'hora_reserva',
        'ruta_id',
        'bus_id',
        'ventanilla_id',
        'usuario_id',
    ];

    public function ruta(){
        return $this->belongsTo(Ruta::class);
    }

    public function bus(){
        return $this->belongsTo(Bus::class);
    }

    public function ventanilla(){
        return $this->belongsTo(Ventanilla::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function facturacion(){
        return $this->hasOne(Facturacion::class);
    }
}
