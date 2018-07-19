<?php
  $user = Auth::user()->group_id;
  $ext = ($user == 4? "layouts.amheader":"layouts.app");
?>
@extends($ext)
@section('content')
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <b style="font-size:1.4em;text-align:center">Cash Deposite Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Count : {{$countrec}}</b>
                <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}"><b>Back</b></a>
            </div>
            <div class="panel-body">
                <table class="table table-responsive table-striped table-hover" border="1">
    				<thead>
                        <th style="text-align:center">Id</th>
                        <th style="text-align:center">User Name</th>
    				    <th style="text-align:center">OrderId</th>
                        <th style="text-align:center">Amount</th>
    					<th style="text-align:center">Bank Name</th>
                        <th style="text-align:center">Deposit Date</th>
                        <th style="text-align:center">Bank Location</th>
    					<th style="text-align:center">Stutus</th>
                        

    					
                        <!-- <th style="text-aligh:center">View Invoice</th> -->
    				</thead>
    				<tbody>
                       <?php
                       $i = 1; 
                       ?>
                        @foreach($cash as $view)
                        <tr>
                        <td> {{ $i++ }}</td>
                        @foreach($dep as $use)
                        @if($use->id == $view->user_id)
                        <td style="text-align:center">{{ $use->name }}</td>
                        @endif
                        @endforeach
                       
                            <td style="text-align:center">{{ $view->orderId }}</td>
					        <td style="text-align:center">
					           {{$view->Amount}}
                            </td>
					        <td style="text-align:center">{{$view->bankname}}</td>
                            <td style="text-align:center">{{$view->bdate}}</td>
                            <td style="text-align:center">{{$view->location}}</td>
                           <td> 
                           <form  method="post" action="{{URL::to('/')}}/close"  >
                            {{ csrf_field() }}
                            <input type="hidden" name="orderid" value="{{ $view->orderId }}">
                                  
                               <button style="margin-top:5px;margin-left:20%;" class="btn btn-success btn-sm"  type="submit">Closed</button>

                           </form>
                         </td>
					      </tr>
                        @endforeach
					   
    			    </tbody>
    			</table>    
            </div>
        </div>
    </div>
</div>

@endsection
