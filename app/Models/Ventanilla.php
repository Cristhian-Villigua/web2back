<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ventanilla extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cooperativa_id',
        'user_id',
    ];

    public function cooperativa(){
        return $this->belongsTo(Cooperativa::class);
    }

    public function reservas(){
        return $this->hasMany(Reserva::class);
    }
    
    public function empleado(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
