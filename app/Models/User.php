<?php

namespace App\Models;

use App\Models\User\Attached_Account;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',
        'address',
        'profession',
        'mobile',
        'isactive',
        

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function accounts(){
        return $this->hasMany(Attached_Account::class,'user_id');
    }

    public function twitter(){
        return $this->accounts->where('verified_acc','twitter')->first();
    }

    public function facebook(){
        return $this->accounts->where('verified_acc','facebook')->first();
    }

    public function tiktok(){
        return $this->accounts->where('verified_acc','tiktok')->first();
    }

}
