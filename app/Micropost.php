<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'user_favorite', 'user_id', 'micropost_id')->withTimestamps();
    }

    
    
}