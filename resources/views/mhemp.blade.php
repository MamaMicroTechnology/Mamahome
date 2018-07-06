<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.img1 {
    border-radius: 50%;

}
/*#boxed {
    border: 1px solid green ;
}*/
.dot {
    height: 10px;
    width: 10px;
    background-color:green;
    border-radius: 50%;
    display: inline-block;
}
</style>
<div class="panel panel-default" style="border-color:green">
<div class="panel-heading" style="background-color:green;font-weight:bold;font-size:1.3em;color:white">Employees on {{ $dept }}
 <a class="pull-right btn btn-xs btn-danger" href="{{url()->previous()}}">Back</a>

</div>

<div class="panel-body" style="height:500px;max-height:500px;overflow-x:hidden; overflow-y:scroll;">

<div class="col-md-12">  
  <div class="col-md-6">
   
    @if($dept == "IT")
    <img src="http://localhost/mamahome/public/MMT LOGO.JPG" height="50" width="100">
     </p> <span class="dot"></span>&nbsp;&nbsp;&nbsp;{{ $count }} employees</p>
    @else
    <img src="http://localhost/mamahome/public/android-icon-36x36.png">
      MAMA HOME PVT LTD<br>
    </p> <span class="dot"></span>&nbsp;&nbsp;&nbsp;{{ $count }} employees</p>
    @endif
  </div>
  
  <div class="col-md-4 pull-right">
            <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." >
  </div>
</div>
<br>
<br>
<br><br><br>

<div id="name">
@foreach($users as $user)
  <a href="{{ URL::to('/') }}/viewEmployee?UserId={{ $user->employeeId }}" >
    <div style="overflow: hidden;" class="col-md-3 col-md-offset-1 img-thumbnail">
    <center><img class="img1" src="http://localhost/mamahome/public/assetbill/1530183607.jpg" width="100" height="100">
      <p style="text-align: center;">{{ $user->name }}</p>
      <small>{{ $user->email }}</small>
    </center>
    @if($loop->iteration % 3==0)
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="row">
        @endif
   </div>
  </a>
@endforeach  
</div>
</div>
</div>
<script>
    function updateUser(arg)
    {
        var userId = arg;
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/updateUser",
            async:false,
            data:{userId : userId},
            success: function(response)
            {
                alert(response);
            }
        });    
    }
    function myFunction()
     {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("name");
    p = ul.getElementsByTagName("a");
    for (i = 0; i < p.length; i++) {
        a = p[i].getElementsByTagName("p")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            p[i].style.display = "";
        } else {
            p[i].style.display = "none";
        }
    }
}
</script>
<!-- src="{{ URL::to('/') }}/public/profilePic/{{ $user->profilepic }}" -->