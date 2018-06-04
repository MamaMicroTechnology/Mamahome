 @extends('layouts.app')
@section('content') 

<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color: green;color: white;pa">SMS
        <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
        </div>
        <div class="panel-body"> 
        	 @if (session('Success'))
                        <div class="alert alert-success">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('Success') }}
                        </div>
               @endif
               @if(session('NotAdded'))
                          <div class="alert alert-danger alert-dismissable">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          {{ session('NotAdded') }}
                          </div>
                @endif
                <form method="POST" name="myform" action="{{URL::to('/')}}/savenumber">
        	 				{{csrf_field()}}
	        	 				<table class="table table-responsive table-striped table-hover" class="table">
	                       			<tbody>
			        	 				<td><label>Enter Phone Number</label></td>
			        	 				<td>:</td>
			        	 				<td><input required type="text" id="num" class="form-control" name="phNo" onblur="checklength('scontact');" onkeyup="getnum()"></td>
			        	 				<td style="text-align: center;"><input class="btn btn-success btn-sm" type="submit" value="Submit" name="submit"></td>
			        	 			</tbody>
			        	 		</table>
		        </form>
            @if(isset($_GET['next']))
              <a href="{{ URL::to('/') }}/sms?next={{ $_GET['next'] + 100 }}">Next</a>
            @else
              <a href="{{ URL::to('/') }}/sms?next=200">Next</a>
            @endif
            @foreach($users as $user)
            @if($user->user_id == Auth::user()->id && $user->sim_number != null)
                 {!! $combine !!}		             
              @endif
                @endforeach 
               </div>
              </div>
              
           </div>	
<script type="text/javascript">
   function getnum()
  {

    var num=document.getElementById('num').value;

      if(isNaN(num)){
        
        document.getElementById('num').value="";
        myform.equantity.focus();
         }
  }
function checklength()
  {
    var x = document.getElementById('num');
    
        if(x.value.length != 10)
        {
            alert('Please Enter 10 Digits in Phone Number');
            document.getElementById('num').value = '';
            return false;
        }
      
  }
</script>
 @endsection