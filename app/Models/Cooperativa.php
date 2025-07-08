<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cooperativa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'dirrecion',
        'celular',
        'user_id',
    ];
    public function ventanillas(){
        return $this->hasMany(Ventanilla::class);
    }

    public function rutas(){
        return $this->hasMany(Ruta::class);
    }

    public function buses(){
        return $this->hasMany(Bus::class);
    }
    public function owner() {
    return $this->belongsTo(User::class, 'user_id');
}
}
