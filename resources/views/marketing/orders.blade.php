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
                <b style="font-size:1.4em;text-align:center">Delivered Orders &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Count : {{$countrec}}</b>
                <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}"><b>Back</b></a>
            </div>
            <div class="panel-body">
                <table class="table table-responsive table-striped table-hover" border="1">
    				<thead>
    				    <th style="text-align:center">Order ID</th>
    				    <th style="text-align:center">Project Id</th>
    					<th style="text-align:center">Main Category</th>
    					<th style="text-align:center">Sub Category</th>
    					<th style="text-align:center">Quantity</th>
    					<th style="text-align:center">Status</th>
    					<th style="text-align:center">Requirement Date</th>
                        <!-- <th style="text-aligh:center">View Invoice</th> -->
    				</thead>
    				<tbody>
                       
                        @foreach($rec as $view)
                        <tr class="{{ in_array($view->orderid, $invoice) ? 'hidden' : '' }}">
					        <td style="text-align:center">
					            <a href="{{URL::to('/')}}/inputinvoice?id={{$view->orderid}}" target="_blank">{{$view->orderid}}</a>
					        </td>
							<td style="text-align:center">{{ $view->project_id }}</td>
					        <td style="text-align:center">{{$view->main_category}}</td>
					        <td style="text-align:center">{{$view->sub_category}}</td>
					        <td style="text-align:center">{{$view->quantity}}</td>
					        <td style="text-align:center">{{$view->status}}</td>
					        <td style="text-align:center">{{ date('d-m-Y', strtotime($view->requirement_date)) }}</td>
                            <!-- <td style="text-align:center">
                                <a href="{{ URL::to('/') }}/invoice?id={{ $view->orderid }}">View Invoice</a>
                            </td> -->
					    </tr>
                        @endforeach
					   
    			    </tbody>
    			</table>    
            </div>
        </div>
    </div>
</div>
@endsection
