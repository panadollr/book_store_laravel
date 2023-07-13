<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'tbl_shipping';
    protected $fillable =[
        'shipping_id',
        'shipping_name',
        'shipping_address',
        'shipping_city',
        'shipping_note',
        'order_id',
        'user_id'
            ];
}
