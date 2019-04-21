<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function generateToken()
    {
        $this->token = sha1(Str::random(10));
        $this->save();
    }

    public function generateOtp()
    {
        $this->password = time() % 1000 .rand(233, 999);
        $this->save();
    }

    public function canTransferAmount($amount)
    {
        return $this->balance >= $amount;
    }
}
