<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'tbl_payment';
    protected $fillable =[
        'payment_id',
        'payment_method'
            ];
}
