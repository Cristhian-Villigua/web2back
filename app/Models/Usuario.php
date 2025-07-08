<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombres',
        'apellidos',
        'cedula',
        'celular',
        'dirrecion',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reservas(){
        return $this->hasMany(Reserva::class);
    }

    public function facturacions(){
        return $this->hasMany(Facturacion::class);
    }
}
