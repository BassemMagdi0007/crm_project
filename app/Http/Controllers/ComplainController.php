<?php

namespace App\Http\Controllers;
use App\Complain;
use App\User;
use App\Reply;
use App\CustomerActiveReply;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
      if(\Auth::user()->role!=2)
         return redirect()->route('home')->with('error',"You Cann't Open This Page");
        $customer_id=\Auth::user()->id;
        return view('complain.create',compact('customer_id'));
    }
  
    public function store(Request $request)
    {
        $this->validate($request,[
          'title' => 'max:255|required',
          'details' => 'required',
          'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'customer_id' => 'numeric|required',
          
        ]);
        if($request->image){
          $imageName = time().'.'.request()->image->getClientOriginalExtension();
          request()->image->move(public_path('images/complains/'), $imageName);
          $image = Complain::create([
              'customer_id' => $request->customer_id,
              'title' => $request->title,
              'details' => $request->details,
              'image' => $imageName,
          ]);
       }
          else{
          $image = Complain::create([
              'customer_id' => $request->customer_id,
              'title' => $request->title,
              'details' => $request->details,
            ]);}
        return redirect(route('home'))->with('message','Your complain Added');
    }
    public function show($ComplainId)
    {
      $complain= Complain::find($ComplainId);
      if(\Auth::user()->role!=0 && $complain->customer->id!=\Auth::user()->id && $complain->employee->id!=\Auth::user()->id )
        return redirect()->route('home')->with('error',"You Cann't Open This Page");
      if(\Auth::user()->role==1 && $complain->state!=1)
        return abort(404);
      elseif(\Auth::user()->role==1 && $complain->state==1 && $complain->employee->id!=\Auth::user()->id)
        return abort(404);
      $user=Complain::find($ComplainId)->customer;
      $employee=Complain::find($ComplainId)->employee;
        if(!$complain)
        abort(404);
      else
        return view('complain.details',compact('complain','user','employee'));
        
    }
   
    public function index($state)
    { 
      if(\Auth::user()->role==0 )
      {
        if($state==0)
        {
          $complains=Complain::where('state',0)->get();
          $employees=User::where('role',1)->get();
          return view('complain.all',compact('complains','state','employees'));
        }
        elseif($state==1)
        {
          $complains=Complain::where('state',1)->get();
          return view('complain.all',compact('complains','state'));
        }
        elseif($state==2)
        {
          $complains=Complain::where('state',2)->get();
          return view('complain.all',compact('complains','state'));
        }
      }
      elseif(\Auth::user()->role==1)
      { if($state!=1)
          return redirect()->route('complain.all',1);
        $user=User::find(\Auth::user()->id);
        $complains=$user->EmployeeComplains->sortByDesc('update_at');
      }
      elseif(\Auth::user()->role==2)
      { 
        $temp = array();
        if($state==2)
        {
          $complains=\Auth::user()->CustomerComplains->sortByDesc('update_at');
          foreach($complains as $complain)
            if($complain->state==2)
              array_push($temp,$complain);
          $complains = $temp;
        }
        elseif($state==1)
        {
          $complains=\Auth::user()->CustomerComplains;
          foreach($complains as $complain)
            if($complain->state!=2)
              array_push($temp,$complain);
          $complains = $temp;
        }
        elseif($state == 0) 
          return redirect()->route('complain.all',1);
        else
        {
          return redirect()->route('home');
        }

      }
      else
        return abort(404);
       
      return view('complain.all',compact('complains','state')); 
     
    }
    
    public function sign(Request $request)
    {
      
      $complain=Complain::find($request->ComplainId);
      $complain->employee_id=$request->Empolyee_id;
      $complain->state=1;
      $complain->update();
      
      return redirect()->route('complain.all',0)->with('message','The Complain Signed');
    }
    public function solved(Request $request)
    {
        $reply=Reply::find($request->ReplyId);
        $reply->active=0;
        $reply->update();
        $active= $active=CustomerActiveReply::where('user_id',\Auth::user()->id)->first();
        if($active)
        {
          $active->number_active_replies--;
          $active->update();
        }
     $complain=Complain::find($request->ComplainId);
      return view('rates.rate',compact('complain'));
    }
    public function unsolved(Request $request)
    {
        $complain=Complain::find($request->ComplainId);
        $complain->state=1;
        $complain->update();
        $active= $active=CustomerActiveReply::where('user_id',\Auth::user()->id)->first();
        if($active)
        {
          $active->number_active_replies--;
          $active->update();
        }
        $reply=Reply::find($request->ReplyId);
        $reply->active=0;
        $reply->update();
        return redirect()->route('home')->with('message','Thank You We Will Try To Solve It Again ');
    }
   
}
