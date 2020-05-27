<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $fillable = [
        'title','details','image','customer_id','employee_id','state',
      ];
  
      public function getImageAttribute($value)
      {
        return asset('images/complains/'.$value);
      }
      public function customer()
      { 
          return $this->belongsTo('App\User', 'customer_id');
      }
      public function employee()
      { 
          return $this->belongsTo('App\User', 'employee_id');
      }
      public function replies()
        { 
            return $this->hasMany('App\Reply','complain_id');
        }
}
