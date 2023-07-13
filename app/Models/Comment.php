<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'tbl_comment';
    protected $fillable =[
        'comment_id',
        'book_id',
        'user_id',
        'comment_content',
        'comment_rating',
        'comment_date'
            ];
}
