<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'user_id','rate','number_rate'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
