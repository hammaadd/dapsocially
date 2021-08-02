<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;
    public function platform(){
        return $this->hasMany(Venue_Social_Post::class,'venue_id');
    }

    public function twitter_added(){
        return $this->platform->where('platform','twitter')->first();
    }

    public function facebook_added(){
        return $this->platform->where('platform','facebook')->first();
    }

    
}
