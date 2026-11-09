<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{   
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_id',
        'nome',
        'estado',
        'descricao',
        'preco',
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }
}