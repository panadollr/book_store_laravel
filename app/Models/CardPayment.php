<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CardPayment extends Model
{
    protected $table = 'tbl_card_payment';
    protected $fillable =[
        'card_payment_id',
        'payment_id',
        'card_name',
        'card_number',
        'exp_month',
        'exp_year',
        'cvv',
        'card_status',
        'date'
            ];
}
