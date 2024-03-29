<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    public function friendships()
    {
        return $this->hasMany(Friendship::class,);
    }
    public function marketplaces()
    {
        return $this->hasMany(Friendship::class,);
    }
    public function chats()
    {
        return $this->hasMany(Chat::class,);
    }
}
