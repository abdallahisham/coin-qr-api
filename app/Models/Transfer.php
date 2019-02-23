<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    public $fillable = [
        'amount'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
