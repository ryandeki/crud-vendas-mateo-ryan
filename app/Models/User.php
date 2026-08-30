<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    protected $fillable = [
        'username',
        'senha'
    ];

    public function items() {
        return $this->hasMany(Item::class);
    }

    public function categories() {
        return $this->hasMany(Category::class);
    }
    
}   