@extends('adminlte::page')
@section('title','Edit Profile')
@section('content_header')
@include('message')
  <h1><i class="fas fa-user-edit text-info"></i> Edit Profile</h1>
@endsection
@section('content')
 
<form class="col-md-6" action="{!!route('profile.update')!!}" method="POST"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
      @if($user->image !=asset('images/users') )
        <i class="fas fa-image"></i>
        <label class="col-sm-5 col-form-label text-info" >Profile image</label>
    <div> <a href="{{$user->image}}" target="_blank"><img src="{{$user->image}}" alt="User profile image" height="120" width="200" style="border-radius:50% " value="{{$user->image}}"></a></div>
      @endif
      <div class="form-group mt-2">
        <i class="fas fa-signature text-info"></i>
        <label>Name</label>
          <input type="text" class="form-control" name="name" value="{{ $user->name }}">
      </div>
      <div class="form-group">
        <i class="fas fa-envelope text-info"></i>
        <label>Email </label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
      </div>
      <div class="form-group">
        <i class="fas fa-image text-info"></i>
        <label> Imgae: </label>
        <input type="file" name="image" value="{{old('image')}}">
        
      </div>
      <div class="form-group mt-4 text-info ml-5">
        <button type="submit" class="btn btn-primary w-75 " ><i class="fas fa-edit fa-sm"></i></button>
      </div>
  </form>
@endsection
