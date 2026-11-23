<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comanda extends Model
{
    use HasFactory;

    protected $fillable = ['mesa_id', 'user_id', 'estado', 'total'];

    public function mesa() {
        return $this->belongsTo(Mesa::class);
    }

    public function productos() {
        // withPivot asegura que traigamos la cantidad y notas de la tabla intermedia
        return $this->belongsToMany(Producto::class)->withPivot('cantidad', 'notas');
    }
}
