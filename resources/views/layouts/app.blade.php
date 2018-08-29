<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MamaHome</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
    <script src="{{ URL::to('/') }}/js/jscolor.js"></script>

    <!-- <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.3.0/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/some.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/app.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="{{ URL::to('/') }}/css/countdown.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <style>
    body{
        font-family: "Times New Roman";
    }
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
    /*******************************Calendar Top Navigation*********************************/
div#calendar{
    margin:0px auto;
    padding:0px;
    width: 602px;
    font-family:Helvetica, "Times New Roman", Times, serif;
  }
   
  div#calendar div.box{
      position:relative;
      top:0px;
      left:0px;
      width:100%;
      height:40px;
      background-color:   #787878 ;      
  }
   
  div#calendar div.header{
      line-height:40px;  
      vertical-align:middle;
      position:absolute;
      left:11px;
      top:0px;
      width:582px;
      height:40px;   
      text-align:center;
  }
   
  div#calendar div.header a.prev,div#calendar div.header a.next{ 
      position:absolute;
      top:0px;   
      height: 17px;
      display:block;
      cursor:pointer;
      text-decoration:none;
      color:#FFF;
  }
   
  div#calendar div.header span.title{
      color:#FFF;
      font-size:18px;
  }
   
   
  div#calendar div.header a.prev{
      left:0px;
  }
   
  div#calendar div.header a.next{
      right:0px;
  }
   
   
   
   
  /*******************************Calendar Content Cells*********************************/
  div#calendar div.box-content{
      border:1px solid #787878 ;
      border-top:none;
  }
  div#calendar ul.label{
      float:left;
      margin: 0px;
      padding: 0px;
      margin-top:5px;
      margin-left: 5px;
  }
  div#calendar ul.label li{
      margin:0px;
      padding:0px;
      margin-right:5px;  
      float:left;
      list-style-type:none;
      width:80px;
      height:40px;
      line-height:40px;
      vertical-align:middle;
      text-align:center;
      color:#000;
      font-size: 15px;
      background-color: transparent;
  }
  div#calendar ul.dates{
      float:left;
      margin: 0px;
      padding: 0px;
      margin-left: 5px;
      margin-bottom: 5px;
  }
  /** overall width = width+padding-right**/
  div#calendar ul.dates li{
      margin:0px;
      padding:0px;
      margin-right:5px;
      margin-top: 5px;
      vertical-align:middle;
      float:left;
      list-style-type:none;
      width:80px;
      height:80px;
      font-size:12px;
      background-color: #DDD;
      color:#000;
      text-align:center; 
  }
   
  :focus{
      outline:none;
  }
   
  div.clear{
      clear:both;
  }
  
  /*Image modal*/
       /* Style the Image Used to Trigger the Modal */
.myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.imgModal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.imgModal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation - Zoom in the Modal */
.imgModal-content, #caption {
    animation-name: zoom;
    animation-duration: 0.6s;
}

@keyframes zoom {
    from {transform:scale(0)}
    to {transform:scale(1)}
}

/* The Close Button */
.imgClose {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.imgClose:hover,
.imgClose:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>
<style>


#go {
  transform: translate(-50%, 0%);
  color: white;
  border: 0;
  background: #71c341;
  width: 100px;
  height: 30px;
  border-radius: 6px;
  font-size: 2rem;
  transition: background 0.2s ease;
  outline: none;
}
#go:hover {
  background: #8ecf68;
}
#go:active {
  background: #5a9f32;
}

.message {
  position: absolute;
  top: -200px;
  left: 50%;
  transform: translate(-50%, 0%);
  width: 300px;
  background: white;
  border-radius: 8px;
  padding: 30px;
  text-align: center;
  font-weight: 300;
  color: #2c2928;
  opacity: 0;
  transition: top 0.3s cubic-bezier(0.31, 0.25, 0.5, 1.5), opacity 0.2s ease-in-out;
}
.message .check {
  position: absolute;
  top: 0;
  left: 50%;
  transform: translate(-50%, -50%) scale(4);
  width: 120px;
  height: 110px;
  background: #71c341;
  color: white;
  font-size: 3.8rem;
  padding-top: 10px;
  border-radius: 50%;
  opacity: 0;
  transition: transform 0.2s 0.25s cubic-bezier(0.31, 0.25, 0.5, 1.5), opacity 0.1s 0.25s ease-in-out;
}
.message .scaledown {
  transform: translate(-50%, -50%) scale(1);
  opacity: 1;
}
.message p {
  font-size: 1.1rem;
  margin: 25px 0px;
  padding: 0;
}
.message p:nth-child(2) {
  font-size: 2.3rem;
  margin: 40px 0px 0px 0px;
}
.message #ok {
  position: relative;
  color: white;
  border: 0;
  background: #71c341;
  width: 100%;
  height: 50px;
  border-radius: 6px;
  font-size: 1.2rem;
  transition: background 0.2s ease;
  outline: none;
}
.message #ok:hover {
  background: #8ecf68;
}
.message #ok:active {
  background: #5a9f32;
}

.comein {
  top: 150px;
  opacity: 1;
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
                    @if(Auth::check())
                    @if(Auth::user()->group_id == 1)
                        <a href="#" class="navbar-brand" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</a>
                    @elseif(Auth::user()->group_id == 2 && Auth::user()->department_id == 1)
                        <a href="#" class="navbar-brand" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</a>
                    @elseif(Auth::user()->group_id == 17 && Auth::user()->department_id == 2)
                        <a href="#" class="navbar-brand" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</a>
                    @elseif(Auth::user()->group_id == 8 && Auth::user()->department_id == 3)
                        <a href="#" class="navbar-brand" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</a>
                     @elseif(Auth::user()->group_id == 7 && Auth::user()->department_id == 2)
                        <a href="#" class="navbar-brand" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</a>
                     @elseif(Auth::user()->group_id == 14)
                        <a href="#" class="navbar-brand" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</a>
                    @endif
                    @endif
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if(Auth::check())
                        <li><a href="{{ URL::to('/') }}/home" style="font-size:1.1em"><b>Home</b></a></li>
                        <!--  -->
                        @if(Auth::user()->department_id == 2  && Auth::user()->group_id == 7)
                         <li><a href="{{ URL::to('/') }}/eqpipeline" style="font-size:1.1em;font-family:Times New Roman"><b>Enquiry Pipelined</b></a></li>
                        @endif
                        @if(Auth::user()->department_id == 1  && Auth::user()->group_id == 6)
                         <li><a href="{{ URL::to('/') }}/eqpipeline" style="font-size:1.1em"><b>Enquiry Pipelined</b></a></li>
                        @endif
                       <!--  @if(Auth::user()->department_id == 0  && Auth::user()->group_id == 1)
                         <li><a href="{{ URL::to('/') }}/eqpipeline" style="font-size:1.1em"><b>Enquiry Pipelined</b></a></li>
                        @endif -->
                         @if(Auth::user()->department_id == 2  && Auth::user()->group_id == 17)
                         <li><a href="{{ URL::to('/') }}/eqpipeline" style="font-size:1.1em"><b>Enquiry Pipelined</b></a></li>
                        @endif
            <?php $d =0 ?>
                         @if(Auth::user()->group_id == 14)
                        <li><a href="{{ URL::to('/') }}/adtraining" style="font-size:1.1em"><b>Training Video <span class="badge">&nbsp;&nbsp;</span></b></a></li>
                        @endif
                        @if(Auth::user()->department_id == 2  && Auth::user()->group_id == 7)
                          <li><a href="{{ URL::to('/') }}/setraining" style="font-size:1.1em"><b>Training Video <span class="badge">&nbsp;{{ $d }}&nbsp;</span></b></a></li>
                        @endif
                       
                        @if(Auth::user()->department_id == 1  && Auth::user()->group_id == 2)
                          <li><a href="{{ URL::to('/') }}/tltraining" style="font-size:1.1em"><b>Training Video <span class="badge">&nbsp;{{ $d }}&nbsp;</span></b></a></li>
                        @endif
                         @if(Auth::user()->department_id == 1  && Auth::user()->group_id == 17)
                          <li><a href="{{ URL::to('/') }}/asttraining" style="font-size:1.1em"><b>Training Video <span class="badge">&nbsp;{{ $d }}&nbsp;</span></b></a></li>
                        @endif
                         @if(Auth::user()->department_id == 0  && Auth::user()->group_id == 1)
                          <li><a href="{{ URL::to('/') }}/adtraining" style="font-size:1.1em"><b>Training Video <span class="badge">&nbsp;{{ $d }}&nbsp;</span></b></a></li>
                        @endif
                         @if(Auth::user()->department_id == 2  && Auth::user()->group_id == 17)
                          <li><a href="{{ URL::to('/') }}/sctraining" style="font-size:1.1em"><b>Training Video <span class="badge">&nbsp;{{ $d }}&nbsp;</span></b></a></li>
                        @endif
                        
                        <li style="padding-top: 10px;">
                          <button id="appblade" class="btn btn-success btn-sm" onclick="submitapp()">Login</button>
                        </li>
                        <li style="padding-top: 10px;padding-left: 10px;"> 
                        <button class="btn btn-danger btn-sm" onclick="submitlogout()">Logout</button>
                       </li>
                        @endif
                    </ul>
                
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="{{ URL::to('/') }}/profile ">Profile</a></li>
                                    @if(Auth::user()->department_id == 2 && Auth::user()->group_id == 7)
                                    <li><a href="{{ URL::to('/') }}/salescompleted ">Completed</a></li>
                                    @endif
                                    @if(Auth::user()->department_id == 0 && Auth::user()->group_id == 1)
                                    <li><a href="{{ URL::to('/') }}/admincompleted?id={{ Auth::user()->id }}">Completed</a></li>
                                    @endif
                                    
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
@if(Auth::check())
@if(Auth::user()->group_id == 1)
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" onclick="closeNav()">&times;</a>
    <a href="{{ URL::to('/') }}/mapping">Mapping</a>
    <a href="{{ URL::to('/getprojectsize') }}">Listed Project & Sizes</a>
    <a href="#" data-toggle="collapse" data-target="#planning">Sales Projection & Planning &#x21F2;</a>
        <div id="planning" class="collapse">
            <a href="{{ URL::to('/projection') }}">&nbsp;&nbsp;&nbsp; - Monthly Sales Projection</a>
            <a href="{{ URL::to('/stage') }}">&nbsp;&nbsp;&nbsp; - Monthly Sales Target</a>
            <a href="{{ URL::to('/yearly') }}">&nbsp;&nbsp;&nbsp; - Yearly Sales Projection</a>
            <a href="{{ URL::to('/fiveyears') }}">&nbsp;&nbsp;&nbsp; - Five Years Sales Projection</a>
            <a href="{{ URL::to('/countryProjection') }}">&nbsp;&nbsp;&nbsp; - One Year Country Projection</a>
            <a href="{{ URL::to('/daily') }}">&nbsp;&nbsp;&nbsp; - Daily Sales Target</a>
            <a href="{{ URL::to('/extensionPlanner') }}">&nbsp;&nbsp;&nbsp; - Extension Planner</a>
        </div>
        <a href="#" data-toggle="collapse" data-target="#Expenditure">Expenditure &#x21F2;</a>
        <div id="Expenditure" class="collapse">
            <a href="{{ URL::to('/expenditure') }}">&nbsp;&nbsp;&nbsp; - Expenditure</a>
            <a href="{{ URL::to('/five_years_expenditure') }}">&nbsp;&nbsp;&nbsp; - Five Years Expenditure</a>
        </div>
    <a href="{{ URL::to('/salesreports') }}">Sales Engineer Report</a>
    <a href="{{ URL::to('/dailyslots') }}">Daily Slots</a>
    <a href="#" data-toggle="collapse" data-target="#projects">Detailed Projects &#x21F2;</a>
        <div id="projects" class="collapse">
            <a href="{{ URL::to('/quality') }}">&nbsp;&nbsp;&nbsp; - Quality of Projects</a>
            <a href="{{ URL::to('/viewallProjects') }}">&nbsp;&nbsp;&nbsp; - View All Projects</a>
            <a href="{{ URL::to('/') }}/Unupdated">&nbsp;&nbsp;&nbsp; -UnUpdated Projects</a>
        </div>
    <a href="{{ URL::to('/ampricing') }}">Pricing</a>
    <a href="#" data-toggle="collapse" data-target="#enquiry">Enquiry &#x21F2;</a>
    <div id="enquiry" class="collapse">
            <a href="{{ URL::to('/adenquirysheet') }}">&nbsp;&nbsp;&nbsp; - Enquiry sheet</a>
            <a href="{{ URL::to('/enquiryCancell') }}">&nbsp;&nbsp;&nbsp; - Enquiry cancelled</a>
        </div>
    <a href="#" data-toggle="collapse" data-target="#orders">Orders &#x21F2;</a>
        <div id="orders" class="collapse">
            <a href="{{ URL::to('/salesStatistics') }}">&nbsp;&nbsp;&nbsp; - Sales Statistics</a>
            <a href="{{ URL::to('/orders') }}">&nbsp;&nbsp;&nbsp; - Orders</a>
           <!--  <a href="{{ URL::to('/mhOrders') }}">&nbsp;&nbsp;&nbsp; - MH Orders</a> -->
        </div>
    <a href="#" data-toggle="collapse" data-target="#demo">Human Resource &#x21F2;</a>
    <div id="demo" class="collapse">
        <a href="#" data-toggle="collapse" data-target="#agent">Employee Attendance &#x21F2;</a>
        <div id="agent" class="collapse">
            <a href="{{ URL::to('/') }}/seniorteam">&nbsp;&nbsp;&nbsp; -Senior Team Leader</a> 
            <a href="{{ URL::to('/') }}/teamleader">&nbsp;&nbsp;&nbsp; -Team Leaders</a> 
            <a href="{{ URL::to('/') }}/saleseng">&nbsp;&nbsp;&nbsp; -Sales Engineer</a> 
            <a href="{{ URL::to('/') }}/marketexe"> &nbsp;&nbsp;&nbsp; -Marketing </a>
            <a href="{{ URL::to('/') }}/teamlisteng">&nbsp;&nbsp;&nbsp; -Listing Engineer</a> 
           
            <a href="{{ URL::to('/') }}/teamacceng"> &nbsp;&nbsp;&nbsp; -Account Executive</a>
            <a href="{{ URL::to('/') }}/market"> &nbsp;&nbsp;&nbsp; -Market Researcher</a>
            <a href="{{ URL::to('/') }}/hr"> &nbsp;&nbsp;&nbsp; -Human Resourse</a>
        </div>
         <a href="#" data-toggle="collapse" data-target="#foffice">Field and Office Logins &#x21F2;</a>
        <div id="foffice" class="collapse">
            <a href="{{ URL::to('/') }}/teamlisteng">&nbsp;&nbsp;&nbsp; -Listing Engineer</a>  
            <a href="{{ URL::to('/') }}/teamacceng"> &nbsp;&nbsp;&nbsp; -Account Executive</a>
            <a href="{{ URL::to('/') }}/ofcemp"> &nbsp;&nbsp;&nbsp; -Office Employees</a>
        </div> 
        <a href="{{ URL::to('/humanresources') }}">&nbsp;&nbsp;&nbsp; - Employees</a>
        <a href="{{ URL::to('/') }}/mhemployee">&nbsp;&nbsp;&nbsp; - MAMAHOME Employee</a>
        <a href="{{ URL::to('/anr') }}">&nbsp;&nbsp;&nbsp; - Reports</a>
        <a href="{{ URL::to('/check') }}">&nbsp;&nbsp;&nbsp; - HR Files and Checklist</a>
        <a href="{{ URL::to('/') }}/assets">&nbsp;&nbsp;&nbsp; - Add Assets</a>
        <a href="{{ URL::to('/') }}/assignassets">&nbsp;&nbsp;&nbsp; - Assign Assets to Department</a>
        <a href="{{ URL::to('/video') }}">&nbsp;&nbsp;&nbsp; - Training Video</a>
        
    </div>
    <a href="#" data-toggle="collapse" data-target="#ap">All Departments &#x21F2;</a>
    <div id="ap" class="collapse">
       <!--  <a href="{{ URL::to('/amdashboard') }}">&nbsp;&nbsp;&nbsp; - Human Resource</a> -->
        <a href="{{ URL::to('/leDashboard') }}">&nbsp;&nbsp;&nbsp; - Operation (LE)</a>
        <a href="{{ URL::to('/teamLead') }}">&nbsp;&nbsp;&nbsp; - Operation (TL)</a>
        <a href="{{ URL::to('/salesEngineer') }}">&nbsp;&nbsp;&nbsp; - Sales Engineer</a>
        <a href="{{ URL::to('/marketing') }}">&nbsp;&nbsp;&nbsp; - Marketing</a>
        <a href="{{ URL::to('/amdashboard') }}">&nbsp;&nbsp;&nbsp; - Asst. Manager of sales</a>
    </div>
    <a href="{{ URL::to('/employeereports') }}">Attendance</a>
    <a href="{{ URL::to('/amdept') }}">Add Authorities</a>
   <!--  <a href="{{ URL::to('/finance') }}">Finance</a> -->
   <a href="{{ URL::to('/letracking') }}">Tracking</a>
    <a href="{{ URL::to('/manufacturerdetails') }}">Manufacturer Details</a>
    <a href="{{ URL::to('/activitylog') }}">Activity Log</a>
    <a href="{{ URL::to('/assignadmin') }}">Assign wards to Admin</a>
    <a href="{{ URL::to('/confidential') }}">Confidential</a>
    <a href="{{ URL::to('/allProjectsWithWards') }}">Data Quality of Projects</a>
    <a href="{{ URL::to('payment') }}">Delivery order Details</a>
     <a href="{{ URL::to('/') }}/viewInvoices">Invoices</a>
  <a href="{{ URL::to('/setprice') }}">Set Products Prices</a>
  <!--  <a href="{{ URL::to('checkdetailes') }}">Cheque Details</a> -->
  <a href="{{ URL::to('/cashdeposit') }}">Cash Deposit Details</a>
  <a href="{{ URL::to('/') }}/adminlatelogin">Late Logins</a>

</div>
@elseif(Auth::user()->group_id == 2 && Auth::user()->department_id == 1)  
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" onclick="closeNav()">&times;</a>
      <a href="{{ URL::to('/assigntl') }}">Assign Team Leaders </a>
   
   
     <a href="#" data-toggle="collapse" data-target="#sales">Sales &#x21F2;</a>

        <div id="sales" class="collapse">

              <a href="{{ URL::to('/orders') }}">&nbsp;&nbsp;&nbsp; -Orders</a>
              <a href="{{ URL::to('/allprice') }}">&nbsp;&nbsp;&nbsp; -Products Prices</a>
              <a href="{{ URL::to('/tlsalesreports') }}">&nbsp;&nbsp;&nbsp; -Sales Engineer Report</a>
              <a href="{{ URL::to('/') }}/tlenquirysheet">&nbsp;&nbsp;&nbsp; -Enquiry Sheet</a>
              <a href="{{ URL::to('/enquiryCancell') }}">&nbsp;&nbsp;&nbsp; -Enquiry cancelled</a>
              <a href="{{ URL::to('/assign_project') }}">&nbsp;&nbsp;&nbsp; -Assign Project</a>
              <a href="{{ URL::to('/assign_number') }}">&nbsp;&nbsp;&nbsp; -Assign Phone numbers</a>
              <a href="{{ URL::to('/assign_enquiry') }}">&nbsp;&nbsp;&nbsp; -Assign Enquiry</a>
        </div>
     <a href="#" data-toggle="collapse" data-target="#operation">Operation &#x21F2;</a>
        <div id="operation" class="collapse">
              <a href="{{ URL::to('/') }}/tlmaps">&nbsp;&nbsp;&nbsp; -Maps</a> 
              <a href="{{ URL::to('/tltracking') }}">&nbsp;&nbsp;&nbsp; -Tracking</a>
               <a href="{{ URL::to('/') }}/Unupdated">&nbsp;&nbsp;&nbsp; -UnUpdated Projects</a>
              <a href="{{ URL::to('/dailyslots') }}">&nbsp;&nbsp;&nbsp; -Daily Slots</a>
              <a href="{{ URL::to('/projectDetailsForTL') }}">&nbsp;&nbsp;&nbsp; -Project Search</a>
              <a href="{{ URL::to('/') }}/assignListSlots">&nbsp;&nbsp;&nbsp; -Assign Listing Engineers and Reports</a>
        </div>   
     <!-- <a href="#" data-toggle="collapse" data-target="#agent">Field Agents &#x21F2;</a>
      <div id="agent" class="collapse">
          <a href="{{ URL::to('/') }}/tlmaps">&nbsp;&nbsp;&nbsp; -Listing Engineer</a> 
          <a href="{{ URL::to('/tltracking') }}">&nbsp;&nbsp;&nbsp; -Account Executive</a>
      </div> -->
      <a href="#" data-toggle="collapse" data-target="#agent">Field and Office logins&#x21F2;</a>
      <div id="agent" class="collapse">
          <a href="{{ URL::to('/') }}/teamlisteng">&nbsp;&nbsp;&nbsp; -Listing Engineer</a> 
          <a href="{{ URL::to('/') }}/teamacceng"> &nbsp;&nbsp;&nbsp; -Account Executive</a>
          <a href="{{ URL::to('/') }}/ofcemp"> &nbsp;&nbsp;&nbsp; -Sales and Operation</a>
          <a href="{{ URL::to('/') }}/listatt">&nbsp;&nbsp;&nbsp; -Listing Engineer Attendance</a> 
          <!-- <a href="{{ URL::to('/') }}/allteamleader">&nbsp;&nbsp;&nbsp; -Team Leaders</a> 
          <a href="{{ URL::to('/') }}/allsaleseng">&nbsp;&nbsp;&nbsp; -Sales Engineer</a> --> 
      </div> 
     <a href="{{ URL::to('/') }}/teamkra"> Add KRA to Operation and Sales</a>
     <a href="{{ URL::to('/') }}/kra">KRA</a> 
     <a href="{{ URL::to('/') }}/teamlatelogin">Late Logins</a>
</div>  


@elseif(Auth::user()->group_id == 17 && Auth::user()->department_id == 2)
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" onclick="closeNav()">&times;</a>
    <a href="{{ URL::to('/allprice') }}">&nbsp;&nbsp;&nbsp; -Products Prices</a>

    <a href="{{ URL::to('/') }}/projectsUpdate" id="updates"  >Assigned Task</a>
    <a href="{{ URL::to('/') }}/sms" >Assigned Phone Numbers</a>
    <a href="{{ URL::to('/projectDetailsForTL') }}">Project Search</a>
    <a href="{{ URL::to('/') }}/scenquirysheet">Enquiry Sheet</a>
    <a href="{{ URL::to('/dailyslots') }}">Daily Slots</a>
    <a href="{{ URL::to('/') }}/enquirywise" style="font-size:1.1em">Assigned Enquiry </a>   
    <a href="{{ URL::to('/') }}/scmaps">Maps</a>
    <a href="{{ URL::to('/') }}/kra">KRA</a>
</div>
@elseif(Auth::user()->group_id == 8 && Auth::user()->department_id == 3)
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" onclick="closeNav()">&times;</a>
     <a href="{{ URL::to('/marketing') }}">Add Products and Brand</a>
     <a href="{{ URL::to('/marketmanufacturerdetails') }}">Manufacturer Details</a>
     <a href="{{ URL::to('/') }}/marketingvendordetails">Vendor details</a>
     <a href="{{ URL::to('/marketingpricing') }}">Pricing</a>
    <a href="{{ URL::to('/') }}/viewInvoices">Invoices</a>
    <a href="{{ URL::to('/') }}/pending">Pending Invoices</a>
      <a href="{{ URL::to('/mrenquirysheet') }}">Enquiry Sheet</a>
      <a href="{{ URL::to('/ordersformarketing') }}">Orders</a>
       <a href="{{ URL::to('payment') }}">Delivery Order Details</a>
       <a href="{{ URL::to('checkdetailes') }}">Cheq Details</a>

      <a href="{{ URL::to('/') }}/kra">KRA</a>
  </div>
  @elseif(Auth::user()->group_id == 7 && Auth::user()->department_id == 2)
<div id="mySidenav" class="sidenav">
     <a href="javascript:void(0)" onclick="closeNav()">&times;</a>
     @if(isset($stages))
       @if($stages->project_ids == null)
       <a href="#" data-toggle="modal" data-target="#myModal" >Assigned Task</a>
       @else
        <a href="{{ URL::to('/') }}/projectsUpdate">Assigned Task</a>
       @endif
     @else
     <a href="{{ URL::to('/') }}/projectsUpdate">Assigned Task</a>

     @endif
    <a href="{{ URL::to('/allprice') }}">Products Prices</a>

     <a href="{{ URL::to('/') }}/sms"  >Assigned Phone Numbers</a>
      <a href="{{ URL::to('/projectDetailsForTL') }}">Project Search</a>
      <a href="{{ URL::to('/') }}/inputview">Add Enquiries</a>
     
    <!--  <a href="{{ URL::to('/mrenquirysheet') }}">Enquiry Sheet</a>  -->
      <!-- <a href="{{ URL::to('/') }}/projectsUpdate" id="updates" >Add Enquiry</a> -->
    <!--  <a href="{{ URL::to('/') }}/status_wise_projects" id="updates" >Statuswise Projects</a>
     <a  href="{{ URL::to('/') }}/date_wise_project" >Datewise Projects</a> -->
    <a href="{{ URL::to('/') }}/followupproject" >Follow Up projects</a>
    <a href="{{ URL::to('/') }}/myreport" >My Report</a>
    <a href="{{ URL::to('/') }}/kra" >KRA</a>           
  </div>
   @elseif(Auth::user()->group_id == 14)
   <div id="mySidenav" class="sidenav">
     <a href="javascript:void(0)" onclick="closeNav()">&times;</a>
            <a href="{{ URL::to('/') }}/amhumanresources">HR</a>
            <a href="{{ URL::to('/') }}/mhemployee">MAMAHOME Employee</a>
            <a href="{{ URL::to('/') }}/amviewattendance">Attendance</a>
            <a href="{{ URL::to('/') }}/check">HR Files and Checklist</a>
            <a href="{{ URL::to('/') }}/assets">Add Assets</a>
            <a href="{{ URL::to('/') }}/assignassets">Assign Assets to Department</a>
            <a href="{{ URL::to('/') }}/video"> Add Training Video</a>
        <a href="#" data-toggle="collapse" data-target="#agent">Employee Attendance &#x21F2;</a>
        <div id="agent" class="collapse">
            <a href="{{ URL::to('/') }}/seniorteam">&nbsp;&nbsp;&nbsp; -Senior Team Leader</a> 
            <!-- <a href="{{ URL::to('/') }}/seniorteam1">&nbsp;&nbsp;&nbsp; -Senior Team Leader1</a> -->
            <a href="{{ URL::to('/') }}/teamleader">&nbsp;&nbsp;&nbsp; -Team Leaders</a> 
            <!-- <a href="{{ URL::to('/') }}/teamleader1">&nbsp;&nbsp;&nbsp; -Team Leaders1</a> -->
            <a href="{{ URL::to('/') }}/saleseng">&nbsp;&nbsp;&nbsp; -Sales Engineer</a> 
            <a href="{{ URL::to('/') }}/marketexe"> &nbsp;&nbsp;&nbsp; -Marketing </a>
            <a href="{{ URL::to('/') }}/teamlisteng">&nbsp;&nbsp;&nbsp; -Listing Engineer</a> 
             <a href="{{ URL::to('/') }}/listatt">&nbsp;&nbsp;&nbsp; -Listing Engineer Attendance</a> 
            <a href="{{ URL::to('/') }}/teamacceng"> &nbsp;&nbsp;&nbsp; -Account Executive</a>
            <a href="{{ URL::to('/') }}/market"> &nbsp;&nbsp;&nbsp; -Market Researcher</a>

        </div> 
        <a href="#" data-toggle="collapse" data-target="#foffice">Field and Office Logins &#x21F2;</a>
        <div id="foffice" class="collapse">
            <a href="{{ URL::to('/') }}/teamlisteng">&nbsp;&nbsp;&nbsp; -Listing Engineer</a>  
            <a href="{{ URL::to('/') }}/teamacceng"> &nbsp;&nbsp;&nbsp; -Account Executive</a>
            <a href="{{ URL::to('/') }}/ofcemp"> &nbsp;&nbsp;&nbsp; -Office Employees</a>
        </div> 
    </div>
        @endif
        @endif
                
                <form method="POST"  action="{{ URL::to('/') }}/logintime" >
                  {{ csrf_field() }}
                                    <input  class="hidden" type="text" name="longitude" value="{{ old('longitude') }}" id="longitudeapp"> 
                                    <input  class="hidden" type="text" name="latitude" value="{{ old('latitude') }}" id="latitudeapp">
                                    <input class="hidden" id="addressapp" type="text" placeholder="Full Address" class="form-control input-sm" name="address" value="{{ old('address') }}">
                        <button id="login" class="hidden" onsubmit="show()" type="submit" >Submit</button>
                </form> 
                 <form method="POST"  action="{{ URL::to('/') }}/emplogouttime" >
                  {{ csrf_field() }}
                    <button id="logout" class="hidden" onsubmit="show()" type="submit" >Submit</button>
                </form>
        @yield('content')
    </div>

 <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header"  style="background-color:#f4811f;padding:2px">
          <h4 class="modal-title">Instructions</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
         @if(isset($stages))
        <center> <b> Instructions </b> </center>
          <p>{{ $stages->instruction }}</p>
        @endif
       <table class="table table-hover ">
                <thead>
                  <th>Time To Complete</th>
                  <th>Assign Ward</th>
                  <th>Assiged Stage</th>
                 <th> Assign Date</th>
               </thead>
                <tbody>
                 @if(isset($stages))
                <tr>
                    <td>
                      {{ date('h:i:s A', strtotime($stages->time )) }}
                    </td>
                    
                   
                    <td>{{ $stages->ward }}</td>
                   
                   
                      <td>{{ $stages->assigndate }} </td>
                  
                </tr>
                      @endif
                    </tbody>
                    </table>
        <center>  <a  href="{{ URL::to('/') }}/projectsUpdate" class="btn btn-primary">Accept To Get Your Projects</a>
         <a  href="{{ URL::to('/') }}/reject" class="btn btn-danger" data-toggle="modal" data-target="#myModal10">Reject</a></center>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
<!-- The Modal -->
  <div class="modal" id="myModal10">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="width:100%;padding:2px;background-color: rgb(191, 191, 63);">
          <h4 class="modal-title">Reason For Rejecting?</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form action="{{ URL::to('/') }}/reject" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        @if(isset($stages))
         <input type="hidden" name="user_id" value="{{ $stages->user_id }}">
         @endif
         <label>Reason : </label>
         <textarea type="text" name="remark" style="width:400px;" ></textarea>
        </div>
       <center> <button type="sunmit" value="submit" class="btn btn-primary">Submit</button></center> 
        </form>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>
    <!-- Scripts -->
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }
        
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
        }
        </script>
    <script>
        // Get the modal
        var modal = document.getElementById('myModal');
        
        // Get the image and insert it inside the modal - use its "alt" text as a caption
        function display(arg){
            var img = document.getElementById(arg);
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            img.onclick = function(){
                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
            }
        }
        
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("imgClose")[0];
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
            modal.style.display = "none";
        }
        </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ URL::to('/') }}/js/countdown.js"></script>
<script>

  function submitlogout(){
    document.getElementById("logout").form.submit();
  }
</script>
 <!-- get location -->
<script src="https://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" charset="utf-8">
  function submitapp(){
      // document.getElementById("getBtn").className = "hidden";
      console.log("Entering getLocation()");
      if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(
        displayappLocation,
        displayappError,

        { 
          maximumAge: 3000, 
          timeout: 5000, 
          enableHighAccuracy: true 
        });
    }else{
      alert("Oops.. No Geo-Location Support !");
    } 
      //console.log("Exiting getLocation()");
  }
    
    function displayappLocation(position){
      //console.log("Entering displayCurrentLocation");
      var latitude  = position.coords.latitude;
      var longitude = position.coords.longitude;
     
      document.getElementById("longitudeapp").value = longitude;
      document.getElementById("latitudeapp").value  = latitude;
      //console.log("Latitude " + latitude +" Longitude " + longitude);

      getAddressFromLatLangapp(latitude,longitude);
      //console.log("Exiting displayCurrentLocation");
    }
   
  function  displayappError(error){
    console.log("Entering ConsultantLocator.displayappError()");
    var errorType = {
      0: "Unknown error",
      1: "Permission denied by user",
      2: "Position is not available",
      3: "Request time out"
    };
    var errorMessage = errorType[error.code];
    if(error.code == 0  || error.code == 2){
      errorMessage = errorMessage + "  " + error.message;
    }
    alert("Error Message " + errorMessage);
    console.log("Exiting ConsultantLocator.displayError()");
  }
  function getAddressFromLatLangapp(lat,lng){
    //console.log("Entering getAddressFromLatLangapp()");
   
    var geocoder = new google.maps.Geocoder();
    var latLng = new google.maps.LatLng(lat, lng);
   
    geocoder.geocode( { 'latLng': latLng}, function(results, status) {
        // console.log("After getting address");
        // console.log(results);
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[0]) {
        // console.log(results);

        document.getElementById("addressapp").value = results[0].formatted_address;
       
        document.getElementById("login").form.submit();

      }
    }else{
        alert("Geocode was not successful for the following reason: " + status);
     }
    });
    //console.log("Entering getAddressFromLatLangapp()");
  }
  
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGSf_6gjXK-5ipH2C2-XFI7eUxbHg1QTU"></script>
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
         <!--  <form action="{{ URL::to('/') }}/emplate" method="POST" > -->
          <p style="text-align:center;">{!! session('Latelogin') !!}</p>
             <!-- {{ csrf_field() }}
          <center><button type="submit" class="btn btn-success" >Submit</button></center>
         </form> -->
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

