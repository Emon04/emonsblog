<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function tags(){
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function favorite_to_users(){
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }
}
