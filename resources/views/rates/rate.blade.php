@extends('adminlte::page')
@section('title','Rate')
@include('message')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card " >
                <div class="card-header">Rate</div>

                <div class="card-body py-0">
                    <div class="d-flex  my-4">
                        @if(\Auth::user()->role==2)
                            <form class="range-field mb-0" style="width:100%" action="{!!route('rate')!!}" method="POST">
                                @csrf
                                <input type="hidden" name="complain_id" value={{$complain->id}}>
                                <input type="hidden" name="employee_id" value={{$complain->employee->id}}>
                                <div class="form-group">
                                    <i class="fas fa-star text-info"></i>
                                    <label>Rate Employee:</label>
                                    <span class="font-weight-bold text-primary EmployeeRate "></span>   
                                    <div class=" d-flex justify-content-center">  
                                        <i class="fas fa-angry fa-lg text-info" ></i>                             
                                    <input id="EmployeeRate" name= "EmployeeRate" class="border-0 custom-range d-inline mx-2" style="width:80%" type="range" min="0" max="10" />
                                    
                                    <i class="fas fa-grin-beam fa-lg float-right text-info" ></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <i class="fas fa-star text-info"></i>
                                    <label>Rate System:</label>
                                    <span class="font-weight-bold text-primary  mt-2 SystemRate " ></span>
                                    <div class=" d-flex justify-content-center">
                                        <i class="fas fa-angry fa-lg text-info" ></i>
                                        <input id="SystemRate" name="SystemRate" class="border-0 custom-range d-inline mx-2 " style="width:80%" type="range" min="0" max="10">
                                        <i class="fas fa-grin-beam fa-lg float-right mt-1 text-info" ></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <i class="fas fa-pencil-alt prefix text-info"></i>
                                    <label>Recomend</label>
                                    <textarea class="form-control" name="SystemRecomand" placeholder="If You Have Any Comment" ></textarea>
                                </div>
                                <div class="form-group">
                                    <a href="{!!route('home')!!}" class="btn btn-secondary col-2 "><i class="fas fa-arrow-left fa-sm"></i> back</a>
                                    <button type="submit"  class="btn btn-primary float-right col-2 ">rate</button>
                                </div>
                            </form>
                        @endif  
                        @if(\Auth::user()->role==1)
                        <form class="range-field mb-0" style="width:100%" action="{!!route('rate')!!}" method="POST">
                            @csrf
                            <input type="hidden" name="ComplainId" value={{$complain->id}}>
                            <input type="hidden" name="customer_id" value={{$complain->customer->id}}>
                            <div class="form-group">
                                <i class="fas fa-star text-info" ></i>
                                <label>Rate customer:</label>
                                <span class="font-weight-bold text-primary CustomerRate "></span> 
                                <div class=" d-flex justify-content-center pt-3 ">
                                    <i class="fas fa-angry fa-lg text-info"  ></i>
                                    <input id="CustomerRate" name="CustomerRate" class="border-0 custom-range d-inline mx-2 " style="width:80%" type="range" min="0" max="10">
                                    <i class="fas fa-grin-beam fa-lg float-right mt-1 text-info" ></i>
                                </div>  
                            </div>
                            
                            <div class="form-group pb-0 pt-3" >
                                <a href="{!!route('home')!!}" class="btn btn-secondary col-2 "><i class="fas fa-arrow-left fa-sm" ></i> back</a>
                                <button type="submit"  class="btn btn-primary float-right col-2 ">rate</button>
                            </div>
                        </form>
                        @endif
                        
                      </div>
                    
                     
                      
                  </div>
                      
                     
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {

            const $EmployeeRateSpan = $('.EmployeeRate');
            const $EmployeeRateValue = $('#EmployeeRate');
            $EmployeeRateSpan.html($EmployeeRateValue.val());
            $EmployeeRateValue.on('input change', () => {
            $EmployeeRateSpan.html($EmployeeRateValue.val());
            });
            
            const $SystemRateSpan = $('.SystemRate');
            const $SystemRateValue = $('#SystemRate');
            $SystemRateSpan.html($SystemRateValue.val());
            $SystemRateValue.on('input change', () => {
            $SystemRateSpan.html($SystemRateValue.val());
            });
            
            // const $CustomerRateSpan = $('.CustomerRate');
            // const $CustomerRateValue = $('#CustomerRate');
            // $CustomerRateSpan.html($CustomerRateValue.val());
            // $CustomerRateValue.on('input change', () => {
            // $CustomerRateSpan.html($CustomerRateValue.val());
            // });
           
        });
    </script>
    
@endsection
