<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'amount', 'number'
    ];

    public static function generate($amount)
    {
    	$card = new static;
    	$card->amount = $amount;
    	$card->number = '1134567899';
    	return $card;
    }
}
