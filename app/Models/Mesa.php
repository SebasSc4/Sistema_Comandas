<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $fillable = ['1,2,4', 'abierta'];

    public function comandas() {
        return $this->hasMany(Comanda::class);
    }
}
