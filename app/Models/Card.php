<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Card.
 */
class Card extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'number',
    ];

    public static function newCardNumber()
    {
        $timeFraction = time() % 10000;
        $randomNumber = rand(11111111111, 99999999999);

        $number = "{$timeFraction}{$randomNumber}";
        if (0 !== static::where('number', $number)->count()) {
            return self::newCardNumber();
        }

        return $number;
    }
}
