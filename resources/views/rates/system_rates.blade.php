@extends('adminlte::page')
@section('title','System Rates')
@section('content_header')
@include('message')
  <h1>All System Rates</h1>
@endsection
@section('content')

  <table class="table">
    <thead>
      <th>#</th>
      <th>System Rate</th>
      <th class="pl-5">From</th>
     </thead>
    <tbody>
      @php($counter=0)
          @foreach ($rates as $rate)
          <tr>
              <td>{{++$counter}})</td>
              <td class="pl-5">{{$rate->rate *10 }} %</td>
            @if($rate->created_at->diffInYears($now)>0)
                <td class="pl-5">{{$rate->created_at->diffInYears($now)}} Year</td> 
              @elseif($rate->created_at->diffInMonths($now)>0)
                <td class="pl-5">{{$rate->created_at->diffInMonths($now)}} Month</td>
              @elseif($rate->created_at->diffInDays($now)>0)
                 <td class="pl-5">{{$rate->created_at->diffInDays($now)}} Day</td>
              @elseif($rate->created_at->diffInHours($now)>0)
                 <td class="pl-5">{{$rate->created_at->diffInHours($now)}} Hours</td> 
              @elseif($rate->created_at->diffInMinutes($now)>0)
                 <td class="pl-5">{{$rate->created_at->diffInMinutes($now)}} Minutes</td> 
              @else
                 <td class="pl-5">now</td> 
            @endif
           
              <td>
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalPush{{$counter}}"><i class="fas fa-eye"></i></button>
                <!--Modal: modalPush-->
                <div class="modal fade" id="modalPush{{$counter}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                  aria-hidden="true" data-backdrop="true" >
                  <div class="modal-dialog modal-notify modal-info" role="document" >
                    <!--Content-->
                    <div class="modal-content text-center" >
                      <!--Header-->
                      <div class="modal-header bg-primary d-flex justify-content-center" >
                        <h5 class="heading m-auto">Hello {{\Auth::user()->name}}</h5>
                        <button type="button" class="btn  btn-sm text-white" data-toggle="modal" data-target="#modalPush{{$counter}}"><i class="fas fa-times"></i> </button>
                      </div>
                      <!--Body-->
                      <div class="modal-body">
                        <i class="fas fa-bell fa-4x animated rotateIn mb-4  "style="color:#33b5e5"></i>
                        @if($rate->feedback)
                            <p>{{$rate->feedback}}</p>
                        @else
                        <p>No Feedback</p>
                        @endif
                        
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