<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Complain;
use App\CustomerActiveReply;
class ReplyController extends Controller
{
    public function store(Request $request)
   {
      Reply::create([
        'reply' => $request->reply,
        'complain_id'=>$request->ComplainId,
      ]);
      $complain=Complain::find($request->ComplainId);
      $complain->state=2;
      $complain->update();
      $active=CustomerActiveReply::where('user_id',$complain->customer_id)->get();
      if($active)
      {
        $active[0]->number_active_replies++;
        $active[0]->update();
      }
        $complain=Complain::find($request->ComplainId);
        return view('rates/rate',compact('complain'))->with('message','asdsadas');
      } 
    
    public function activeReplies()
    {
      $active=CustomerActiveReply::where('user_id',\Auth::user()->id)->get();
      if(\Auth::user()->role==2 && count($active) && $active[0]->number_active_replies)
      {
        $replies=Reply::where('active',1)->get()->sortByDesc('created_at');
        $customer_replies=array();
        foreach($replies as $reply)
        if($reply->complain->customer_id==\Auth::user()->id)
          $customer_replies[]=$reply;
        $now=\Carbon\Carbon::now();
        return view('replies.active',compact(['customer_replies','now']));
      }
      elseif(\Auth::user()->role==2 && count($active) && $active[0]->number_active_replies ==0 ) 
        return redirect()->route('home')->with('error',"you didn't have any active replies");
      else
        return redirect()->route('home')->with('error',"you can't open this page");
    }
    public function historyReplies()
    {
      if(\Auth::user()->role==2)
      {
        $replies=Reply::where('active',0)->get()->sortByDesc('created_at');
        $customer_replies=array();
        foreach($replies as $reply)
        if($reply->complain->customer_id==\Auth::user()->id)
          $customer_replies[]=$reply;
        $now=\Carbon\Carbon::now();
        return view('replies.histroy',compact(['customer_replies','now']));
      }
      else
        return redirect()->route('home')->with('error',"you can't open this page");
    }
}
