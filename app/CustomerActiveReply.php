<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerActiveReply extends Model
{
    protected $fillable = [
        'user_id', 'number_active_replies',
    ];
}
