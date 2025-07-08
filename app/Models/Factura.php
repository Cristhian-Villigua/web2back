<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'monto',
        'reserva_id',
        'usuario_id',
    ];
    public function reserva(){
        return $this->belongsTo(Reserva::class);
    }

    public function user(){
        return $this->belongsTo(Usuario::class);
    }
}
