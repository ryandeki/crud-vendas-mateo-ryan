<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    protected $fillabel = [
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'cidade',
        'bairro',
        'uf'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
