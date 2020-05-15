@extends('adminlte::page')
@section('title','All Users')
@section('content_header')
@include('message')
@if ($role == 0)
    <h1>ALL Admins</h1>
@elseif ($role == 1)
    <h1>ALL Employees</h1>
@elseif($role == 2)
    <h1>ALL Customers</h1>
@endif
@endsection
@section('content')

  <table class="table datatable">
    <thead>
      <th>#</th>
      <th>ID</th>
      <th>User Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Actions</th>
    </thead>
    <tbody>
      @foreach ($users as  $index => $user)
      <tr>
         
          <td><b>{{ $index+1 }})</b></td>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          @if ($user->role == 0)
            <td>Admin</td>
          @endif
          @if ($user->role == 1)
            <td>Employee</td>
          @endif
          @if ($user->role == 2)
            <td>customer</td>
          @endif
          
            <td>
              @if(\Auth::user()->id != $user->id)
                <a href="{!! route('user.data',$user->id) !!}" method="post" class="btn btn-success btn-sm mr-1"><i class="fas fa-eye"></i></a>
                <a href="" method="post" class="btn btn-danger btn-sm mr-1"><i class="fas fa-trash"></i></a>
              @else
              <a href="{!! route('user.data',$user->id) !!}" method="post" class="btn btn-success btn-sm mr-1 text-center ml-3"><i class="fas fa-eye"></i></a>
              @endif
            </td>
         
        </tr>
      @endforeach
    </tbody>
  </table>
  {{-- <div class="row">
    <div class="  modal-dialog ">{{$users->links()}}</div>
  </div> --}}
@endsection
  