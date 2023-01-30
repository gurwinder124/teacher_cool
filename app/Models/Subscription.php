<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public const SUBSCRIBE = 1;
    public const NOT_SUBSCRIBE = 0;


    public static function subscriptionStatus()
    {
        return [
            ['value'=>static::NOT_SUBSCRIBE, 'name' => "Not Subscribe"],
            ['value'=>static::SUBSCRIBE, 'name' =>  "Subscribed"],
        ];
    }
}
