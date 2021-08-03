<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;



    /**
     * Get the region record associated with the user.
     */
    public function region()
    {
        return $this->hasOne('App\Region','id', 'region_id');
    }
}
