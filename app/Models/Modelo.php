<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'air_bag', 'abs'];

    public function marca()
    {
        //Um modelo pertence a uma marca
        return $this->belongsTo(Marca::class);
    }


    //Nao e necessario, mas coloquei pra que se caso eu quiser recuperar algo de carros no modelo
    public function carros()
    {
        //Um modelo possui a varios carros
        return $this->hasMany(Carro::class);
    }
}
