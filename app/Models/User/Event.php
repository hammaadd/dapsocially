<?php

namespace App\Models\User;

use App\Models\Event_Social_Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;


    public function platform(){
        return $this->hasMany(Event_Social_Post::class,'event_id');
    }

    public function twitter_added(){
        return $this->platform->where('platform','twitter')->first();
    }

    public function facebook_added(){
        return $this->platform->where('platform','facebook')->first();
    }

    public function tiktok_added(){
        return $this->platform->where('platform','tiktok')->first();
    }

    public function instagram_added(){
        return $this->platform->where('platform','insta')->first();
    }
}
