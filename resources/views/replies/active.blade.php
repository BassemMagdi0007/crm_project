@extends('adminlte::page')
@section('title','All Replies')
@section('content_header')
  <h1>All Replies</h1>
@endsection
@section('content')
@include('message')
  <table class="table  text-center" >
    <thead>
      <th>#</th>
      <th>This Reply Form</th>
      <th>actions</th>
    </thead>
    <tbody>
      @php($counter=0)
      
          @foreach ($customer_replies as  $index => $reply)
          <tr>
              <td>{{++$index}})</td>
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
                        <i class="fas fa-bell fa-4x animated rotateIn mb-4  "style="color:#33b5e5"></i>
                        <p>{{$reply->reply}}</p>
                      </div>
                      <!--Footer-->
                      <div class="modal-footer m-auto">
                      </div>
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
