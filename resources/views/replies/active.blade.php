@extends('adminlte::page')
@section('title','Active Replies')
@section('content_header')
  <h1>Active Replies</h1>
@endsection
@section('content')
@include('message')
  <table class="table  text-center" >
    <thead>
      <th>#</th>
      <th>Complain ID</th>
      <th>This Reply Form</th>
      <th>actions</th>
    </thead>
    <tbody>
          @foreach ($customer_replies as  $index => $reply)
          <tr>
              <td>{{++$index}})</td>
              <td>{{$reply->complain->id}}</td>
              @if($reply->created_at->diffInYears($now)>0)
              <td class="pl-5 ">{{$reply->created_at->diffInYears($now)}} Year</td> 
              @elseif($reply->created_at->diffInMonths($now)>0)
              <td class="pl-5 ">{{$reply->created_at->diffInMonths($now)}} Month</td>
              @elseif($reply->created_at->diffInDays($now)>0)
              <td class="pl-5 ">{{$reply->created_at->diffInDays($now)}} Day</td>
              @elseif($reply->created_at->diffInHours($now)>0)
              <td class="pl-5 ">{{$reply->created_at->diffInHours($now)}} Hours</td> 
              @elseif($reply->created_at->diffInMinutes($now)>0)
              <td class="pl-5 ">{{$reply->created_at->diffInMinutes($now)}} Minutes</td> 
              @else
              <td class="pl-5 ">now</td> 
            @endif
              <td>
                @if ($reply->active)
                <button type="button" class="btn btn-success btn-sm  w-25"  data-toggle="modal" data-target="#modalPush{{$index}}"><i class="fas fa-eye "></i></button>
                @endif
                <!--Modal: modalPush-->
                <div class="modal fade" id="modalPush{{$index}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                  aria-hidden="true" data-backdrop="false" >
                  <div class="modal-dialog modal-notify modal-info" role="document" >
                    <!--Content-->
                    <div class="modal-content text-center" >
                      <!--Header-->
                      <div class="modal-header bg-primary d-flex justify-content-center" >
                      <h5 class="heading m-auto">Hello {{\Auth::user()->name}}</h5>
                      <button type="button" class="btn  btn-sm" data-toggle="modal" data-target="#modalPush{{$index}}"><i class="fas fa-times text-white"></i></button>
                      </div>
                      <!--Body-->
                      <div class="modal-body">
                        <label for="">Employee Reply is:</label>
                        <i class="far fa-comment-dots fa-4x animated rotateIn mb-4 ml-2  "style="color:#33b5e5"></i>
                        <p>{{$reply->reply}}</p>
                      </div>
                      <!--Footer-->
                     
                        <div class="modal-footer m-auto">
                          {{-- <form action="{!!route('rate.view')!!}" method="POST">
                            @csrf
                            <input type="hidden" name="ComplainId" value="{{$reply->complain_id}}">
                            <input type="hidden" name="ReplyId" value="{{$reply->id}}">
                            <button type="submit" class="btn btn-info ml-2">Rate</button>
                          </form> --}}
                          <form action="{!!route('unsolved')!!}" method="POST">
                            @csrf
                            @method('Put')
                            <input type="hidden" name="ComplainId" value="{{$reply->complain_id}}">
                            <input type="hidden" name="ReplyId" value="{{$reply->id}}">
                            <button type="submit" class="btn btn-danger ml-2">UnSolved</button>
                          </form>
                            
                          <form action="{!!route('solved')!!}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="ComplainId" value="{{$reply->complain_id}}">
                            <input type="hidden" name="ReplyId" value="{{$reply->id}}">
                            <button type="submit" class="btn btn-success m-2">Solved</button>
                          </form>
                      </div>
                    
                    <!--/.Content-->
                  </div>
                </div>
                <!--Modal: modalPush-->
              </td>
            </tr>
          @endforeach
      </tbody>
    </table>   
@endsection
