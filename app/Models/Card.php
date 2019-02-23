<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Card.
 *
 * @package namespace App\Models;
 */
class Card extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'number'
    ];
}
