<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{   
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'nome',
        'descricao',
        'status',
    ];
    
    public function items() {
        return $this->hasMany(Item::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }


}