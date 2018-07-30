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
                <b style="font-size:1.4em;text-align:center">Cheque Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Count : {{$countrec}}</b>
                <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}"><b>Back</b></a>
            </div>
            <div class="panel-body">
                <table class="table table-responsive table-striped table-hover" border="1">
    				<thead>
                        <th style="text-align:center">Cheq Id</th>
    				    <th style="text-align:center">Project Id</th>
                        <th style="text-align:center">Order ID</th>
    					<th style="text-align:center">Cheque Number</th>
                        <th style="text-align:center">Amount</th>
                        <th style="text-align:center">cheque Image</th>
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
                            <td style="text-align:center">
                                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal{{$view->id }}">
                                    Cheque Image
                                  </button>
                            </td>   
  

  <!-- The Modal -->
  <div class="modal" id="myModal{{ $view->id }}">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
    <div class="modal-header" style="background-color:#337ab7;padding:1px;">
          <h4 class="modal-title" style="color:white;">Cheque Image</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <img src="{{ URL::to('/')}}/public/chequeimages/{{ $view->image }}" style="width: 500px;height:500px">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div><td>
<form action="{{URL::to('/')}}/clearcheck" method="post" enctype="multipart/form-data">
                                   {{ csrf_field() }}
                                  <input type="hidden" name="id" value="{{ $view->orderId }}">
                                <select class="form-control" name="satus" style="width:50%;" >

                                  <option value="">----Select----</option>
                                  
                                  <option  {{ $view->orders->payment_mode == "Cheq Clear" ? 'selected' : '' }}  value="Cheq Clear">Cheq Clear</option>
                                  <option  {{ $view->orders->payment_mode == "Cheq processing" ? 'selected' : '' }} value="Cheq processing">Cheq Processing</option>

                                </select>
                               <button style="margin-top:-55px;margin-left:60%;" class="btn btn-success btn-sm" type="submit" value="submit" >submit</button>
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
