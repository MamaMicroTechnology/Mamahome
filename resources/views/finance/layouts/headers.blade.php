<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MamaHome | Finance</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <style>
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        
        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 15px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }
        
        .sidenav a:hover {
            color: #f1f1f1;
        }
        
        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        
        #main {
            transition: margin-left .5s;
            padding: 16px;
        }
        
        @media screen and (max-height: 450px) {
          .sidenav {padding-top: 15px;}
          .sidenav a {font-size: 18px;}
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                    <a href="#" class="navbar-brand" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if(Auth::check())
                        <li><a href="{{ URL::to('/') }}/home" style="font-size:1.1em"><b>Home</b></a></li>
                        <li><a href="{{ URL::to('/') }}/sctraining" style="font-size:1.1em"><b>Training Video <span class="badge"></span></b></a></li>
                        <li style="padding-top: 10px;padding-left: 10px;">
                            <button id="appblade" class="btn btn-success btn-sm" onclick="submitapp()">Login</button>
                        </li>
                        <li style="padding-top: 10px;padding-left: 10px;"> 
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#break">Break</button>
                        </li>
                        <li style="padding-top: 10px;padding-left: 10px;"> 
                            <button class="btn btn-danger btn-sm" data-toggle="modal" onclick="confirmthis()">Logout</button>
                        </li>
                    @endif
                </ul>
            
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <!-- <li><a href="{{ route('login') }}">Login</a></li> -->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li><a href="{{ URL::to('/') }}/profile ">Profile</a></li>
                                <li><a href="{{ URL::to('/')}}/changePassword">Change Password</a></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('authlogout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</div>


<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" onclick="closeNav()">&times;</a>
    <a href="{{ URL::to('/orders') }}">Orders</a>
    <a href="{{ URL::to('/') }}/financeDashboard"> Confirmed Orders</a>
    <!-- <a href="{{ URL::to('/financeAttendance') }}">Attendance</a> -->
    <a href="{{ URL::to('/') }}/gstinformation">GST Information</a>
    <a href="{{ URL::to('/') }}/gstinformation">ADD Ledger Files</a>

</div>


@yield('content')
<!-- break time modal -->
 <div id="break" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="width:50%;" >
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Break Time</h4>
        </div>
        <div class="modal-body">

        <p>Click On Start To Take a Break?</p>
        <form id="timer" action="{{ URL::to('/') }}/breaktime" method="POST">
            {{ csrf_field() }}
        <button type="submit" class="btn btn-success btn-sm">START</button>
        </form>
        <form id="timer" action="{{ URL::to('/') }}/sbreaktime" method="POST">
            {{ csrf_field() }}
        <button style="margin-top:-20%;margin-left: 70px;" type="submit" class="btn btn-danger btn-sm">STOP</button>
        </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
        </div>
    </div>

    </div>
</div>
<!-- break time modal ends -->
<!-- report modal -->
<div id="report" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color:rgb(244, 129, 31);color:white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">MAMAHOME EMPLOYEE ATTENDANCE</h4>
            </div>
            <div class="modal-body">
                <form action="{{ URL::to('/') }}/empreports" method="POST">
                    {{ csrf_field() }}
                    <table class="table table-hover" id="reports">
                        <thead>
                            <th>Report</th>
                            <th>From</th>
                            <th>To</th>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <td><input required type="text" name="report[]" id="report" class="form-control" placeholder="Report"></td>
                                <td><input required type="time" name="from[]" id="from" class="form-control"></td>
                                <td><input required type="time" name="to[]" id="to" class="form-control"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="btn-group">
                        <button type="button" onclick="myFunction1()" class="btn btn-warning btn-sm">
                            &nbsp; <span class="glyphicon glyphicon-plus"></span>&nbsp;
                        </button>
                        <button type="button" onclick="myDelete1()" class="btn btn-danger btn-sm">
                            &nbsp; <span class="glyphicon glyphicon-minus"></span>&nbsp;
                        </button>
                    </div>
                            
                    <div class="panel-footer">
                        <input type="submit" value="Submit" class="form-control btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- report modal ends -->
<form method="POST"  action="{{ URL::to('/') }}/logintime" >
    {{ csrf_field() }}
    <button id="login" class="hidden" onsubmit="show()" type="submit" >Submit</button>
</form>

@if(session('empSuccess'))
  <div class="modal fade" id="empSuccess" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #5cb85c;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Success</h4>
        </div>
        <div class="modal-body">
          <p style="text-align:center;">{!! session('empSuccess') !!}</p>
        </div>
        <div class="modal-footer">
          <button type="button" style="background-color: #c9ced6;" class="btn btn-default" data-dismiss="modal" onClick="window.location.reload()">Close</button>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $(document).ready(function(){
      $("#empSuccess").modal('show');
  });
</script>
@endif
@if(session('Latelogin'))
  <div class="modal fade" id="emplate" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #f27d7d;color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Late Login</h4>
        </div>
        <div class="modal-body">
       
          <p style="text-align:center;">{!! session('Latelogin') !!}</p>
             
        </div>
        <div class="modal-footer">
          <button type="button" style="background-color: #c9ced6;" class="btn btn-default" data-dismiss="modal" onClick="window.location.reload()">Close</button>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $(document).ready(function(){
      $("#emplate").modal('show');
  });
</script>
@endif

<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }
    
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
    function submitapp(){
        document.getElementById("login").form.submit();
    }
    function confirmthis()
    {
        var ans = confirm('Are You Sure You Want To Logout ?');
        if(ans)
        {
            $(document).ready(function(){
                $("#report").modal('show');
            });
        }
    }
    function myFunction1() {
        var table = document.getElementById("reports");
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        cell1.innerHTML = "<input required type='text' name='report[]' id='report' class='form-control' placeholder='Report'>";
        cell2.innerHTML = "<input required type='time' name='from[]' id='from' class='form-control'>";
        cell3.innerHTML = "<input required type='time' name='to[]' id='to' class='form-control'>";
    }
    function myDelete1() {
        var table = document.getElementById("reports");
        if(table.rows.length >= {{ 3 }}){
            document.getElementById("reports").deleteRow(-1);
        }
    }
</script>
</body>
</html>