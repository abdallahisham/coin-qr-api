<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Card.
 */
class Card extends Model
{
    protected $fillable = [
        'amount', 'number',
    ];
}
