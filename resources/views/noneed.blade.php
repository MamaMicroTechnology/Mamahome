 @extends('layouts.app')
@section('content') 

<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color: green;"><p style="color:white;">Unwanted  Phone Numbers</p>
          <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-30px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;"></i></button>
        </div>
        <div class="panel-body"> 
                <form method="POST" name="myform" action="{{URL::to('/')}}/noneed">
        	 				{{csrf_field()}}
	        	 				<table class="table table-responsive table-striped table-hover" class="table">
	                       			<tbody>
			        	 				<td><label>Enter Phone Number</label></td>
			        	 				<td>:</td>
			        	 				<td><input required type="text"  class="form-control" name="number" onblur="checklength('scontact');" onkeyup="getnum()" placeholder="Enter Your Mobile Number"></td>
                        <td><button type="submit">submit</button>
			        	 		</tbody>
			        	 		</table>
		        </form>
             @foreach($number as $s)
                        
                            <table class="table table-striped">
                              <tr>
                            <?php
                              $j = 0;
                              $numbers = explode(", ",$s->number);
                              for($i = 0; $i < count($numbers); $i++){
                                echo("<td>".$numbers[$i]."</td>");
                                $j++;
                                if($j == 5){
                                  $j = 0;
                                  echo("</tr>");
                                }
                              }
                            ?>
                              </tr>
                            </table>
                           
                    
                        @endforeach              
              
               </div>
              </div>
           </div>	


@if(session('success'))
          <script>
            swal("Success","{{ session('success')}}","success");
          </script>
 @endif
 @endsection
