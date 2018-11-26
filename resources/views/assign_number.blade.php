<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 1? "layouts.teamheader":"layouts.app");
?>
@extends($ext)

@section('content')
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">

        <div class="panel-heading" style="background-color: green;color: white;">Select Project Status Before Assigning The Phone Numbers  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
           <form method="GET" action="{{ URL::to('/') }}/assign_number">
                <input type="hidden" name="delete" value="delete">
                <input type="submit" value="Reset" class=" btn-danger btn btn-sm">
              </form>

       <center> <button class="btn btn-success " type="button" style="background-color: #00e676;color: white" data-toggle="modal" id="#myModal"  data-target="#myModal">Select Project Status</button></center>
          <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-60px;margin-left:10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color:black;"></i></button>
        </div>
        <div class="panel-body">
              <form method="POST" id="saveNumber" name="myform" action="{{ URL::to('/') }}/storecount" enctype="multipart/form-data">
                {{ csrf_field() }}    
<!--                 <input type="hidden" id="userId" name="user_id">
                <input type="hidden" id="number" name="num">               -->
             <table class="table table-responsive table-striped table-hover" class="table">       
                      <tr>
                        <td>
                         <h4>TOTAL :<b>{{$count }} <br><br>
                              </b> List Of Team Members</h4><br>
                              <?php
                                  $s=  $count;
                                ?> 
                <select name="user_id" onchange="this.form.submit()" class="form-control" style="width: 30%;">
                          <option value="">--Select--</option>
                          
                          @foreach($users as $user)  
                            <option value="{{ $user->id }}">{{$user->name}}</option>
                           @endforeach
                           @if(Auth::user()->group_id == 22)
                            @foreach($tlUsers as $user)  
                            <option value="{{ $user->id }}">{{$user->name}}</option>
                           @endforeach
                           @endif
                            </select>
                         
                          <center>  <h4>Phone Numbers</h4></center>

                        </td>
                     </tr> 

                   <tr>
                     <td>
                       <?php
                          $numbers = array();
                       ?>
                       <table class="table table-striped">
                       <tr>
                       <?php $i = 0; ?>
                        @foreach($number as $num)
                         <td>{{ $num->number }}</td>
                         <?php
                            $i++;
                            $temp = $num->number;
                            array_push($numbers, $temp);
                          ?>
                         @if($i == 6)
                          </tr>
                          <?php $i = 0; ?>
                          @endif
                         @endforeach
                         <?php
                            $numb = implode(", ", $numbers);
                         ?>
                       </table>
                      <input type="hidden" name="num" value="{{ $numb }}">
                     </td>
                   </tr>
                </table>  
              </form> 
    {{ $number->links()  }}
      <form method="POST" name="myform" action="{{ URL::to('/') }}/sms" enctype="multipart/form-data">
     {{ csrf_field() }}
     <input type="hidden" id="userId" name="user_id">
      <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog" style="width: 70%;" >

                    <!-- Modal content-->
                    <div class="modal-content" >
                      <div class="modal-header" style="background-color:rgb(244, 129, 31);color:white">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align: center;">Select Stages</h4>
                      </div>
                      <div class="modal-body">
                                    
                                
                                 
                                  <div class="row">
                                 <div class="col-sm-12">
                                    <table>
                                       <tr id="sp">
                                       <div class="checkbox">
                                      <lable><td style=" padding:20px 40px 20px 40px;" ><input type="checkbox" name="stage[]" value="Planning">&nbsp;&nbsp;Planning</td>
                                           <td  style=" padding:20px 40px 20px 40px;"><input type="checkbox" name="stage[]" value="Digging">&nbsp;&nbsp;Digging</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Foundation">&nbsp;&nbsp;Foundation</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Pillars">&nbsp;&nbsp;Pillars</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Walls">&nbsp;&nbsp;Walls</td></lable>
                                         </div>
                                       </tr>    
                                         <tr id="sp">
                                       <div class="checkbox">
                                      <lable><td  style=" padding:20px 40px 20px 40px;"><input type="checkbox" name="stage[]" value="Roofing">&nbsp;&nbsp;Roofing</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Electrical">&nbsp;&nbsp;Electrical</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Plumbing">&nbsp;&nbsp;Plumbing</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Plastering">&nbsp;&nbsp;Plastering</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Flooring">&nbsp;&nbsp;Flooring</td></lable>
                                           </div>
                                       </tr>  
                                        <tr id="sp">
                                       <div class="checkbox">
                                      <lable>     <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Carpentry">&nbsp;&nbsp;Carpentry</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Paintings">&nbsp;&nbsp;Paintings</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Fixtures">&nbsp;&nbsp;Fixtures</td>
                                          <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Completion">&nbsp;&nbsp;Completion</td>
                                           <td  style=" padding:0 40px 0 40px;"><input type="checkbox" name="stage[]" value="Closed">&nbsp;&nbsp;Closed</td></lable>
                                           </div>
                                       </tr>    
                                      </table>
                                    </div>
                              </div>


                               <div class="modal-footer">
                                 <button type="submit"  class="btn btn-success">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>

                    </div>  
                  </div>
                </div>
              </div>
            </form>
           </div>
    </div>
</div>
<script type="text/javascript">
  function makeUserId(arg){
  document.getElementById("userId").value = arg;
  
}
function submitMyNumber(arg){
  document.getElementById("userId").value = document.getElementById(arg+"userId").value;
  document.getElementById("number").value = document.getElementById(arg+"num").value;
  var form = document.getElementById("saveNumber");
  form.submit();
}
</script>
 @if(session('success'))
          <script>
            swal("Success","{{ session('success')}}","success");
          </script>
 @endif
 @if(session('NotAdded'))
          <script>
            swal("Error","{{ session('NotAdded')}}","error");
          </script>
  @endif
@endsection
