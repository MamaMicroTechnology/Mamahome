@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{asset('js/gmaps.js')}}"></script>
    <script src="{{ URL::to('/') }}/js/jscolor.js"></script>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="{{ URL::to('/') }}/css/countdown.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
* {box-sizing: border-box}
/* Style the tab */
.tab {
    float: left;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    width: 30%;
    height: 300px;
}

/* Style the buttons inside the tab */
.tab button {
    display: block;
    background-color: inherit;
    color: black;
    padding: 22px 16px;
    width: 100%;
    border: none;
    outline: none;
    text-align: left;
    cursor: pointer;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    float: left;
    padding: 0px 12px;
    border: 1px solid #ccc;
    width: 70%;
    border-left: none;
    height: 300px;
    display: none;
}

/* Clear floats after the tab */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}
</style>
</head>
<body>
<div class="col-md-12">
    <div class="panel panel-primary" style="overflow-x: scroll;">
        <div class="panel-heading text-center">
            <b style="color:white;font-size:1.4em">GST Information</b>
           <button type="button" onclick="history.back(-1)" class="btn btn-default pull-right" style="margin-top:-3px;" > <i class="fa fa-arrow-circle-left" style="width:30px;"></i></button>
        </div>
        <div id="myordertable" class="panel-body">
            <form action="orders" method="get">
                <div class="input-group col-md-3 pull-right">
                    <input type="text" class="form-control pull-left" placeholder="Enter Order id" name="projectId" id="projectId">
                    
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
                </div>
            </form>
             
            <br><br>
            <table class="table table-responsive table-striped" border="1">
                <thead>
                    <tr>
        <th>Order Id</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>CGST(%)</th>
        <th>SGST(%)</th>
         <th>IGST(%)</th>
         <th>Mamahome Price</th>
        <th>MGSTWith(Amt)</th>
        <th>MGSTWithOut(Amt)</th>
         <th>Suplier Price</th>
         <th>SGSTWith(Amt)</th>
        <th>SGSTWithOut(Amt)</th>
        <th>Mamahome Income</th>


              </tr>
                </thead>
                <tbody>
 @foreach($data as $mamadata)
      <tr>
       <td>{{$mamadata['id']}}</td>
       <td>{{$mamadata['category']}}</td>
       <td>{{$mamadata['quantity']}}</td>
       <td>{{$mamadata['Mamacgst']}}</td>
       <td>{{$mamadata['Mamasgst']}}</td>
       <td>{{$mamadata['Mamaigst']}}</td>
       <td>{{$mamadata['Mamaprice']}}</td>
       <td>{{$mamadata['Mamawithgst']}}</td>
       <td>{{$mamadata['Mamawithoutgst']}}</td>
       <td>{{$mamadata['sprice']}}</td>
       <td>{{$mamadata['swithgst']}}</td>
       <td>{{$mamadata['swithoutgst']}}</td>
       <td>{{$mamadata['income']}}</td>



      </tr>
      @endforeach


                   </tbody>
               </table>
           </div>
       </div>
   </div>
</body>
</html>
@endsection