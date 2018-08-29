
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
  
  <link rel="stylesheet" href="alert/dist/sweetalert.css">
 <script src="alert/dist/sweetalert-dev.js"></script>

  <title></title>
</head>
<body>
<div class="topnav">
  <a class="active"  href="javascript:history.back()" style="font-size:1.1em;font-family:Times New Roman;margin-left:15%;">Home</a>
</div><br><br>
<style>
* {box-sizing: border-box;}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color:#e7e7e7;
  margin-right: 0;
margin-left: 0;
}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  
  color: black;
}

.topnav .search-container {
  float: right;
}

.topnav input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
}

.topnav .search-container button {
  float: right;
  padding: 6px 10px;
  margin-top: 8px;
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.topnav .search-container button:hover {
  background: #ccc;
}

@media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;  
  }
}
</style>
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
                    @if (session()->has('success'))
                    <center><h4 style="color:green;size:20px;">{{ session('success') }}</h4></center>
                  @endif
            
                    
    <form method="POST" id="assign" action="{{ url('/tlward')}}" >
    {{ csrf_field() }}
    <input type="hidden" id="username" name="user_id">
    <input type="hidden" id="username1" name="group_id">

    <select  name="ward_id" id="dateassigned" class="hidden" required >
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
                            <th>Assigned Ward </th>
                            <th>Assign Ward </th>
                            <th>Select Users</th>
                            <th>Assigned Users</th>
                            <th>Action</th>
                        </thead>
                        <tbody>

                           <tr>
                           <th>{{ $i++ }}</th>
                            <td>{{ $user->name }}</td>
                            
                            <input type="hidden" id= "user{{ $user->id }}" name="user_id" value="{{$user->id}}">
                            <input type="hidden" id= "user1{{ $user->id }}" name="group_id" value="{{$user->group_id}}">
                            @foreach($tlward as $tlwards)
                            @if($user->id == $tlwards->user_id )
                              <td style="width:40%;">{{ $tlwards->ward_name != null ? $tlwards->ward_name :'' }}</td>
                            @endif
                          @endforeach
                            <td style="width: 40%;">
                            <select name="ward_id" id="date{{ $user->id }}" class="form-control">
                              <option value="select">----Select Ward----</option>
                            @foreach($ward as $wards)
                              <option value="{{$wards->id}}"> {{ $wards->ward_name }}</option>

                             @endforeach
                            </select> 
                             
                            </td>
                            
                          <td>
                            <div class="form-group">
                             <select id="menu{{$user->id}}" name="framework[]" multiple class="form-control" style="width: 60%;" required>
                             @foreach($user1 as $users2)
                              <option  value="{{$users2->id}}"> {{ $users2->name }} [{{$users2->dept_name}}]</option>
                             @endforeach
                            </select> 
                             </div>
                            </td>
                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal{{ $user->id }}">
           Assigned Users
</button></td>
                            <td>
                              <button class="btn btn-success pull-left" onclick="return confirm('Are you sure You Select Ward and Subward ?');">Assign</button>
                            </td>
                          </tr>         
                       </tbody>
                </table>
            </div>
    </form>
     @endforeach
     @foreach($newUsers as $newUser)
    <div class="modal" id="myModal{{ $newUser['tl_id'] }}">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="background-color:#f4811f">
        <h4 class="modal-title">Assigned Users</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <table class="table table-responsive table-striped table-hover">
                        <thead>
                          <tr>
                            <th style="color:#337ab7;size:20px;">Name</th>
                            <th style="color:#337ab7;size:20px;">Designation</th>
                          </tr>
                        </thead>
                        <tbody>

                @foreach($newUser['employees'] as $employees)
                           <tr>
                           <th>{{ $employees['name'] }}</th>
                            @foreach($user1 as $users2)
                            @if($employees['id'] == $users2->id)
                            <th>{{$users2->dept_name}}</th>
                            @endif
                            @endforeach
                            
                 </tr>
                  @endforeach
                 </tbody>
                 </table>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
      </div>

    </div>
  </div>
</div>
  @endforeach
 {{$users->links()}}

                  </div>
              </div>
          </div>
    </div>
</div>
 </nav>
  
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


