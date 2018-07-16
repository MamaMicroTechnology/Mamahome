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
                <b style="font-size:1.4em;text-align:center">Cheq Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Count : {{$countrec}}</b>
                <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}"><b>Back</b></a>
            </div>
            <div class="panel-body">
                <table class="table table-responsive table-striped table-hover" border="1">
    				<thead>
                        <th style="text-align:center">Cheq Id</th>
    				    <th style="text-align:center">Project Id</th>
                        <th style="text-align:center">Order ID</th>
    					<th style="text-align:center">Check Number</th>
                        <th style="text-align:center">Amount</th>
                        <th style="text-align:center">Check Date</th>
    					<th style="text-align:center">Cheq status</th>
                        

    					
                        <!-- <th style="text-aligh:center">View Invoice</th> -->
    				</thead>
    				<tbody>
                       
                        @foreach($details as $view)
                        <tr>
                        <td style="text-align:center">{{ $view->id }}</td>
                            <td style="text-align:center">{{ $view->project_id }}</td>
					        <td style="text-align:center">
					           {{$view->orderId}}
                            </td>
					        <td style="text-align:center">{{$view->checkno}}</td>
                            <td style="text-align:center">{{$view->amount}}</td>
                            <td style="text-align:center">{{$view->date}}</td>
                           <td> <form action="{{URL::to('/')}}/clearcheck" method="post">
                                   {{ csrf_field() }}
                                  <input type="hidden" name="id" value="{{ $view->orderId }}">
                                <select class="form-control" onchange="form.submit()" name="satus">

                                  <option value="">----Select----</option>
                                 
                                  <option value="Cheq Clear">Cheq Clear</option>
                                </select>

                            </form></td>
					      </tr>
                        @endforeach
					   
    			    </tbody>
    			</table>    
            </div>
        </div>
    </div>
</div>
@endsection
