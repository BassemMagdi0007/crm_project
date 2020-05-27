@extends('adminlte::page')
@section('title','User profile')
@section('content_header')
@include('message')
<i class="fas fa-user-circle fa-2x text-info"></i>
  <h1 class="d-inline">User profile:</h1>
@endsection
@section('content')
<table class="table " style="margin-bottom:5px">
  <tbody>
    @if($user->image!= asset('images/users/'))
    <i class="fas fa-image mr-1 text-info "></i>
    <label>Complain Image:</label>
    <br>  
    <tr>
      <td><a href="{{$user->image}}" target="_blank"><img src="{{$user->image}}" alt="User profile image" style="border-radius:50%" height="120" width="200"></a></td>
    </tr>
    @endif
    <tr>
      <td >
        <i class="fas fa-signature text-info"></i>
        <label for="">User Name:</label>
        {{ $user->name }}
      </td>
    </tr>
    <tr>
      <td>
        <i class="fas fa-envelope text-info"></i>
        <label for="">User Email:</label>
         {{ $user->email }}</td>
     </tr>
      
        @if(\Auth::user()->role == 0 )
          <tr>
            @if($user->role == 0)
                <td>
                  <i class="fas fa-fingerprint text-info"></i>
                  <label for=""> User role:Admin </label>
                  </td>
            @endif
            @if($user->role == 1)
              <td>
                  <i class="fas fa-fingerprint text-info"></i>
                  <label for=""> User role:</label> Employee  
              </td>
            @endif
        @endif 
      </tbody>
</table>
  @if(\Auth::user()->id == $user->id)
    <div>
      <a href="{!!route('edit.profile')!!}" style="width: 30%" class="btn btn-primary btn-mg " ><i class="fas fa-edit fa-sm"></i></a>
    </div>
  @endif  
@endsection