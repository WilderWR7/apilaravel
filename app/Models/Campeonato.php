<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campeonato extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','disciplina','slug'];

    public function categorias() {
        return $this->hasMany(Categoria::class);
    }

}
