<?php

namespace App\Http\Controllers;
use App\Complain;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
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
   

}