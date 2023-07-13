<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'tbl_order';
    protected $fillable =[
        'order_id',
        'payment_id',
        'order_total',
        'order_status',
        'date',
            ];
}
