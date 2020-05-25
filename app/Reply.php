<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'complain_id','reply','active'
      ];
    public function complain()
    { 
        return $this->belongsTo('App\Complain', 'complain_id');
        
    }

}
