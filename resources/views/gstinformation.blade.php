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
        <div class="panel-heading" style="height:50px;">
        <form action="{{ URL::to('/') }}/gstinformation" method="get" class="pull-left">
                       	{{ csrf_field() }}
                       	<div class="col-md-3">
						<input value = "{{ isset($_GET['from']) ? $_GET['from']: '' }}" type="date" class="form-control" name="from">

							</div>
							<div class="col-md-3">
								<input  value = "{{ isset($_GET['to']) ? $_GET['to']: '' }}" type="date" class="form-control" name="to">
							</div>
							<div class="col-md-3">
								<select id="categ" class="form-control" name="category">
								<option value="">--Select Category--</option>
								@foreach($category as $category)
								<option {{ isset($_GET['category']) ? $_GET['category'] == $category->category_name ? 'selected' : '' : '' }} value="{{ $category->category_name }}">{{ $category->category_name }}</option>
								@endforeach
							</select>
							</div>
							<div class="col-md-3">
                       	 <button type="submit" value="Submit" class="form-control btn btn-sm btn-success" >submit</button>
								
							</div>
                       	
                       </form>
           
        </div>
        <div id="myordertable" class="panel-body">
        

             
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
         <th>Selling Price<br>(Mamahome)</th>
        <th>Mamahome<br>(GSTWith Amt)</th>
        <th>Mamahome<br>(GSTWithOut Amt)</th>
         <th> Buying Price<br>(Suplier)</th>
         <th>Suplier<br>(GSTWithAmt)</th>
        <th>Suplier <br>(GSTWithOut Amt)</th>
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
       <td>{{number_format(round($mamadata['Mamaprice']))}}</td>
       <td>{{number_format(round($mamadata['Mamawithgst']))}}</td>
       <td>{{number_format(round($mamadata['Mamawithoutgst']))}}</td>
       <td>{{number_format(round($mamadata['sprice']))}}</td>
       <td>{{number_format(round($mamadata['swithgst']))}}</td>
       <td>{{number_format(round($mamadata['swithoutgst']))}}</td>
       <td>{{number_format(round($mamadata['income']))}}</td>
   </tr>
      @endforeach
      <tr>
      	 <td>Total</td>
       <td>-</td>
       <td>-</td>
       <td>-</td>
       <td>-</td>
       <td>-</td>
       <td>-</td>
        <?php 
       $da4 = sizeof($data);   
        $sumdata4 = [];
         $i=0;
       for($i=0;$i<$da4;$i++){
      
           $d4 = $data[$i]['Mamawithgst'];
           array_push($sumdata4,$d4);
       } 

     $fdata4 = array_sum($sumdata4);
       ?>
       <td>{{number_format(round($fdata4))}}</td>
        <?php 
       $da3 = sizeof($data);   
        $sumdata3 = [];
         $i=0;
       for($i=0;$i<$da3;$i++){
      
           $d3 = $data[$i]['Mamawithoutgst'];
           array_push($sumdata3,$d3);
       } 

     $fdata3 = array_sum($sumdata3);
       ?>
       <td>{{number_format(round($fdata3))}}</td>
       <td>-</td>
        <?php 
       $da2 = sizeof($data);   
        $sumdata2 = [];
         $i=0;
       for($i=0;$i<$da2;$i++){
      
           $d2 = $data[$i]['swithgst'];
           array_push($sumdata2,$d2);
       } 

     $fdata2 = array_sum($sumdata2);
       ?>
       <td>{{number_format(round($fdata2))}}</td>
       <?php 
       $da1 = sizeof($data);   
        $sumdata1 = [];
         $i=0;
       for($i=0;$i<$da1;$i++){
      
           $d1 = $data[$i]['swithoutgst'];
           array_push($sumdata1,$d1);
       } 

     $fdata1 = array_sum($sumdata1);
       ?>
       <td>{{number_format(round($fdata1))}}</td>
       <?php 
       $da = sizeof($data);   
        $sumdata = [];
         $i=0;
       for($i=0;$i<$da;$i++){
      
           $d = $data[$i]['income'];
           array_push($sumdata,$d);
       } 

     $fdata = array_sum($sumdata);
       ?>
       <td>{{number_format(round($fdata))}}</td>
      </tr>
</tbody>
               </table>
           </div>
       </div>
   </div>
</body>
</html>
@endsection