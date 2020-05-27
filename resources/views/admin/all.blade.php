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
                @if($user->role==1 && count($user->EmployeeComplains)>0)
              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalPush{{$index}}"><i class="fas fa-trash"></i></button>
                    <!--Modal: modalPush-->
              <div class="modal fade" id="modalPush{{$index}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                      aria-hidden="true" data-backdrop="false" >
                      <div class="modal-dialog modal-notify modal-info" role="document" >
                        <!--Content-->
                        <div class="modal-content text-center" >
                          <!--Header-->
                          <div class="modal-header bg-danger d-flex justify-content-center" >
                          <h5 class="heading m-auto">Hello {{\Auth::user()->name}}</h5>
                          <button type="button"  class="btn text-white" data-toggle="modal" data-target="#modalPush{{$index}}"><i class="fas fa-times"></i></button>

                          </div>
                          <!--Body-->
                          <div class="modal-body">
                            <i class="fas fa-trash text-danger fa-4x animated rotateIn mb-4 d-block"></i>
                            <strong>Please Note That You Will Delete This Employee </strong>
                            <p>This Employee Have Complains </p>
                            <p>If You Want To Delete Him Please Choose Employee To Replace him With This Employee </p>
                          </div>
                          <!--Footer-->
                          <div class="modal-footer m-auto">
                          <form action="{!!route('user.delete')!!}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="destroy_id" value="{{$user->id}}">
                            <select class="form-control" name="employee_name" id="">
                              <option selected disabled >Select Employee</option>
                              @foreach ($users as $employee)
                                @if($employee==$user)
                                  @continue
                                @endif
                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                              @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary m-2"><i class="fas fa-check"></i></button>
                          </form>
                            
                          </div>
                        </div>
                        <!--/.Content-->
                      </div>
                    </div>  
                    @else            
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalPush{{$index}}"><i class="fas fa-trash"></i></button>
                    <!--Modal: modalPush-->
              <div class="modal fade" id="modalPush{{$index}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                      aria-hidden="true" data-backdrop="false" >
                      <div class="modal-dialog modal-notify modal-info" role="document" >
                        <!--Content-->
                        <div class="modal-content text-center" >
                          <!--Header-->
                          <div class="modal-header bg-danger d-flex justify-content-center" >
                          <h5 class="heading m-auto">Hello {{\Auth::user()->name}}</h5>
                          <button type="button"  class="btn text-white" data-toggle="modal" data-target="#modalPush{{$index}}"><i class="fas fa-times"></i></button>

                          </div>
                          <!--Body-->
                          <div class="modal-body">
                            <i class="fas fa-trash text-danger fa-4x animated rotateIn mb-4 d-block"></i>
                            <strong>Please Note That You Will Delete: {{$user->name}} </strong> 
                          </div>
                          <!--Footer-->
                          <div class="modal-footer m-auto">
                          <form action="{!!route('user.delete')!!}" method="POST" delete="delete{{$user->id}}" class="delete{{$user->id}}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="destroy_id" value="{{$user->id}}">
                            <button type="submit" class="btn btn-danger m-2"><i class="fas fa-trash"></i></button>
                          </form>
                            
                          </div>
                        </div>
                        <!--/.Content-->
                      </div>
                    </div>
                @endif  
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
  