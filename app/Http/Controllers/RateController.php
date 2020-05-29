<?php

namespace App\Http\Controllers;
use App\Complain;
use App\User;
use App\CustomerActiveReply;
use App\Reply;
use App\SystemRate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function Rateview(Request $request)
    { 
      if(\Auth::user()->role==2)
      {
        $reply=Reply::find($request->ReplyId);
        $reply->active=0;
        $reply->update();
        $active=CustomerActiveReply::where('user_id',\Auth::user()->id)->get();
        if($active)
        {
          $active[0]->number_active_replies--;
          $active[0]->update();  
        }
      }
     $complain=Complain::find($request->ComplainId);
      return view('rates.rate',compact('complain'));
    }
    public function rate(Request $request)
    {
      if(\Auth::user()->role==2)
        {
          $complain=Complain::find($request->complain_id);
          $complain->rate=$request->EmployeeRate;
          $complain->update();
          $employee=User::find($request->employee_id);
          $employee->rate->rate+=$request->EmployeeRate;
          $employee->rate->number_rate++;
          $employee->rate->update();
          $system_rate=SystemRate::create(['rate'=>$request->SystemRate,'feedback'=>$request->SystemRecomand]);
        }
        elseif(\Auth::user()->role==1)
        {
          $customer=User::find($request->customer_id);
          $customer->rate->rate+=$request->CustomerRate;
          $customer->rate->number_rate++;
          $customer->rate->update();
        } 
        return redirect()->route('complain.all',1)->with('message','Thank you for your feedback');
        
    }
}
