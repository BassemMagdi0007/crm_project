<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Reply;
class UsersController extends Controller
{
    
    public function create()
    {
      if(\Auth::user()->role!=0)
        return redirect()->route('home')->with('error',"You Cann't Open This Page");
      return view('admin.create');
    }

    public function store(Request $request)
    {
      $this->validate($request,[
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|min:8',
      'password-confirm' =>'required|min:8|same:password',
      'role' => 'required|integer|max:2|min:0',
      'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
      if(!$request->image){
        $image = user::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Hash::make($request->password),
            'role' => $request->role,
          ]);}
          else{
          $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images/users/'), $imageName);
            $image = User::create([
              'name' => $request->name,
              'email' => $request->email,
              'password' => Hash::make($request->password),
              'role' => $request->role,
              'image' => $imageName,
            ]);}

      return redirect()->route('user.all',$request->role)->with('message','You added a new user sucssefully');
    }

    public function show($id)
    {
      if(\Auth::user()->role==2 && $id != \Auth::user()->id)
        return redirect()->route('user.data',\Auth::user()->id);
      $user= User::find($id);
      if(!$user)
         return redirect()->route('home')->with('error',"This Profile Not Found");
      elseif(\Auth::user()->role==1 && $user->role ==0)
        return redirect()->route('home')->with('error',"You Cann't Open This Profile"); 
      else
      { 
          return view('profile.showprofile',compact('user'));
      }
    }
    public function ChangeForm()
    {
      return view('profile.changepassword');
    }
    public function changePassword(Request $request)
    {
      $this->validate($request,[
        'password' => 'required',
        ]);
      $user=user::find($request->id);
      if(Hash::check($request->password,$user->password))
      {
        $this->validate($request,[
          'password' => 'required|min:8',
          'newpassword' => 'required|min:8',
          'confirmpassword' =>'required|min:8|same:newpassword',
          ]);
      $user->update(['password'=>Hash::make($request->newpassword)]);
      return redirect()->route('profile.change.form')->with('message','Your Password Updated');
      }
      else
      {
        return redirect()->route('profile.change.form')->with('error','Wrong Old Password');
      }
    }
    Public function index($role)
    {
      if($role<3 && $role>=0){
        if(\Auth::user()->role !=0)
          return redirect()->back()->with('error',"You Cann't Open This Page");
      $users= User::where('role','=',$role)->get();
      if(!$users)
        abort(404);
      else
        return(view('admin.all',compact(['users','role'])));}
      else
        abort(404);
    }
    
    public function destroy(Request $request)
    {  $user=user::find($request->destroy_id);
      if(!$user)
        return abort(404);
        if(count($user->EmployeeComplains)>0)
      {
          $this->validate($request,['employee_name' =>['required']]);
      }
    
      if($user->role==1 && count($user->EmployeeComplains)>0)
      { 
        $complains=$user->EmployeeComplains;
        foreach($complains as $complain)

            $complain->update(['employee_id'=>$request->employee_name]);
        
      }
    elseif($user->role==2 && count($user->CustomerComplains)>0 )
      {
        $complains=$user->CustomerComplains;
        foreach($complains as $complain) 
          {if(count($complain->replies)>0)
            {
              $replies=Reply::where('complain_id',$complain->id)->get();
              foreach($replies as $reply)
                $reply->delete();
          }
            $complain->delete();
          }
      }  
      $user->delete();
      return redirect()->back()->with('message',"It's deleted successfully");
    }
    public function edit()
    {
      $user = User::find(\Auth::user()->id);
      if(!$user)
        abort(404);
      else
        return view('profile.editprofile',compact('user'));
    }
    public function update(Request $request)
    {
      if($request->email!=\Auth::user()->email){
         $this->validate($request,['email' => ['required', 'string', 'email', 'max:255', 'unique:users'],]);}
      if($request->image)
      {
         $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
        $user=user::find(\Auth::user()->id);
        $request = $request->except('__token');
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images/users'), $imageName);
        $user->update($request);
        $user->image=$imageName;        
        $user->update();
    }
    else {
      $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
      ]);
     $user=user::find(\Auth::user()->id);
     $request = $request->except('__token');
     $user->update($request);
    }
     return redirect()->route('user.data',\Auth::user()->id)->with('message','your profile Updated Successfully');
    }
}
