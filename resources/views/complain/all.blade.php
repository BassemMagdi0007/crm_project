@extends('adminlte::page')
@section('title','All Complains')
@section('content_header')
@include('message')
  <h1>All Complains</h1>
@endsection
@section('content')
  <table class="table ">
    <thead>
      <th>#</th>
      <th>Complain Id</th>
      <th>complain title</th>
      <th>state</th>
    </thead>
    <tbody>
      @php($counter=0)
      
          @foreach ($complains as  $index => $complain)
              @if(\Auth::user()->role==1 &&$complain->state!=1)
                @continue
              @endif
          <tr>
              <td>{{++$counter}})</td>
              <td class="pl-5">{{$complain->id}}</td>
              <td>{{$complain->title}}</td>
              @if($state==0 && \Auth::user()->role==0)
                <td>unsign</td>
              @elseif($state==0 && \Auth::user()->role==2)
                <td>active</td>
              @elseif($state==2 && \Auth::user()->role==0)
                <td>unsign</td>
              @elseif($state==2 && \Auth::user()->role==2)
                <td>active</td>
              @endif
              
              <td>                    
                <a href="{!! route('complain.details',$complain->id) !!}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Show</button>       
             </td>
            </tr>
          @endforeach
      </tbody>
    </table>
    {{--<div class="row d-flex justify-content-center ">
      <div class="  ">{{$complains->links()}}</div>
    </div>--}}
    
@endsection
