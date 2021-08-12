<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\Event;
use App\Models\User\Venue;

class Event_checkouts extends Model
{
    use HasFactory;

    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function veneus()
    {
        return $this->belongsTo(Venue::class, 'veneu_id');
    }
}
