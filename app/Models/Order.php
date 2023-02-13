<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory; 

    public const SUBSCRIPTION_ORDER_TYPE = 1;
    public const OTHER_ORDER_TYPE = 2;

    public const ORDER_PAYMENT_PAID = 1;
    public const ORDER_PAYMENT_PENDING = 2;
}
