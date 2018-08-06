<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
  <title></title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="border-color:#f4811f">
                <div class="panel-heading text-center" style="background-color:#f4811f"><b style="color:white;font-size:1.3em">Assign Ward To Team Leaders Of Operation And Sales</b>
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                <a  href="javascript:history.back()" class="btn btn-sm btn-danger pull-right">Back</a>    
                </div>
                <div class="panel-body">
            
    
                    
    <form method="POST" id="assign" action="{{ url('/tlward')}}" >
    {{ csrf_field() }}
    <input type="hidden" id="username" name="user_id">
    <input type="hidden" id="username1" name="group_id">

    <select  name="ward_id" id="dateassigned" class="hidden" >
                              <option value="select">----------Select Ward------</option>
                            @foreach($ward as $wards)
                              <option {{ $wards->id  ? 'selected' : '' }} value="{{$wards->id}}">      {{ $wards->ward_name }}</option>
                            @endforeach
                            </select> 
                            <select id="dateassigned1" name="framework[]" multiple class="form-control hidden" >
                             @foreach($user1 as $users2)
                              <option value="{{$users2->id}}"> {{ $users2->name }}</option>
                             @endforeach
                            </select> 
    </form>
         <?php $i=1 ?>
         @foreach($users as $user)
         <form method="POST" id="assign" action="{{ url('/tlward')}}" >
          {{ csrf_field() }}
               <div class="panel-body">
                <table class="table table-responsive table-striped table-hover">
                        <thead>
                             <th>No.</th>
                            <th>Team Leader Name</th>
                            <th>Assign Ward </th>
                            <th>Select Users</th>
                            <th>Action</th>

                            
                          </thead>
                        <tbody>

                           <tr>
                           <th>{{ $i++ }}</th>
                            <td>{{ $user->name }}</td>
                            
                            <input type="hidden" id= "user{{ $user->id }}" name="user_id" value="{{$user->id}}">
                            <input type="hidden" id= "user1{{ $user->id }}" name="group_id" value="{{$user->group_id}}">

                            <td style="width: 40%;">
                            <select name="ward_id" id="date{{ $user->id }}" class="form-control"  >
                              <option value="select">----Select Ward----</option>
                            @foreach($ward as $wards)
                              <option value="{{$wards->id}}"> {{ $wards->ward_name }}</option>

                             @endforeach
                            </select> 
                             
                            </td>
                          <td>
                            <div class="form-group">
                             <select id="menu{{$user->id}}" name="framework[]" multiple class="form-control" style="width: 60%;" >
                             @foreach($user1 as $users2)
                              <option  value="{{$users2->id}}"> {{ $users2->name }}</option>
                             @endforeach
                            </select> 
                             </div>
                            </td>
                            <td><button type="submit" class="btn btn-success pull-left">Assign</button></td>
                          </tr>         
                       </tbody>
                </table>
            </div>
    </form>
     @endforeach
  
 {{$users->links()}}

                  </div>
              </div>
          </div>
    </div>
</div>
  
<script>
    function save(arg){
        document.getElementById('username').value = document.getElementById('user'+arg).value;
        document.getElementById('username1').value = document.getElementById('user1'+arg).value;

        document.getElementById('dateassigned').value = document.getElementById('date'+arg).value;
        document.getElementById('dateassigned1').value = document.getElementById('menu'+arg).value;
        var selected = document.getElementById('menu'+arg);
        alert(selected.selectedIndex);

        document.getElementById('assign').submit();
    }
</script>

<script>
$(document).ready(function(){
  @foreach($users as $user)
   $('#menu{{$user->id}}').multiselect({
      nonSelectedText: 'Select Users',
      enableFiltering: true,
      enableCaseInsensitiveFiltering: true,
      buttonWidth:'200px'
   });
   @endforeach
 });

$(document).ready(function(){
  @foreach($users as $user)
   $('#date{{$user->id}}').multiselect({
      nonSelectedText: 'Select Ward',
      enableFiltering: true,
      enableCaseInsensitiveFiltering: true,
      buttonWidth:'200px'
   });
   @endforeach
 });
$(document).ready(function(){
  @foreach($users as $user)
   $('#date3{{$user->id}}').multiselect({
      nonSelectedText: 'Select Ward',
      enableFiltering: true,
      enableCaseInsensitiveFiltering: true,
      buttonWidth:'200px'
   });
   @endforeach
 });
</script>

<script>
function checkall(arg){
  alert(arg);
var clist = document.getElementById('ward'+arg).getElementsByTagName('input');
  if(document.getElementById('check'+arg).checked == true){
    for (var i = 0; i < clist.length; ++i) 
    { 
      clist[i].checked = true; 
    }
  }else{
    for (var i = 0; i < clist.length; ++i) 
    { 
      clist[i].checked = false; 
    }
  }
}
</script>   

</body>
</html>


