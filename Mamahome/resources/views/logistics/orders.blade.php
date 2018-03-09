@extends('layouts.logisticslayout')
@section('title','Logistics Orders')
@section('content')
<div class="col-md-12 col-sm-12">
	<div class="panel panel-primary" style="overflow-x: scroll;">
		<div class="panel-heading text-center">
			<b style="color:white;font-size:1.4em">Confirmed Orders &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total Count : {{$count}}</b>
			<a class="pull-right btn btn-sm btn-danger" href="{{URL::to('/')}}/home" id="btn1" style="color:white;"><b>Back</b></a>
		</div>
		<div class="panel-body">
			<table class="table table-responsive table-striped">
				<thead>
				    <th style="text-align:center">Project ID</th>
					<!--<th style="text-align:center">Main Category</th>-->
					<!--<th style="text-align:center">Sub Category</th>-->
					<th style="text-align:center">Quantity</th>
					
					<th style="text-align:center">Status</th>
					<th style="text-align:center">Dispatch Status</th>
					<!--<th style="text-align:center">Requirement Date</th>-->
					<th style="text-align:center">Action</th>
					
					<!--<th style="text-align:center">Delivery Status</th>-->
					
				</thead>
				<tbody>
					@foreach($view as $rec)
					<tr id="row-{{$rec->id}}">
						<td style="text-align:center"><a href="{{URL::to('/')}}/{{$rec->project_id}}/showProjectDetails">{{$rec -> project_id}}</a></td>
						<!--<td style="text-align:center">{{--$rec->main_category--}}</td>-->
						<!--<td style="text-align:center">{{--$rec->sub_category--}}</td>-->
						<td style="text-align:center">{{$rec->quantity}} {{$rec->measurement_unit}}</td>
						<td style="text-align:center">{{$rec->status}}</td>
						<td style="text-align:center">
						@if($rec->dispatch_status=='Yes')
						    Dispatched
						@else
						    Not Yet Dispatched
						@endif    
						</td>
						<!--<td style="text-align:center">{{--$rec->requirement_date--}}</td>-->
                        <td style="text-align:center">
                            @if($rec->status == 'Order Confirmed')
                            <button onclick="init('myCanvas{{$rec->id}}')" type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#myModal{{$rec->id}}">Open Modal</button>
                            @endif
                        </td>
                        
						<!--<td style="text-align:center">{{--$rec->delivery_status--}}</td>-->
					    <!--@if($rec->status !== 'Order Confirmed')-->
					    <!--    <td style="text-align:center">-->
					    <!--        <a onclick="confirmOrder('{{--$rec->id--}}')" class="btn btn-sm btn-success" style="width:99%">-->
					    <!--            <b>Confirm Order</b>-->
					    <!--        </a>-->
					    <!--    </td>-->
					    <!--@else-->
					    <!--    <td style="text-align:center">-->
					    <!--        <a onclick="cancelOrder('{{--$rec->id--}}')" class="btn btn-sm btn-danger" style="width:99%" >-->
					    <!--            <b>Cancel Order</b>-->
					    <!--        </a>-->
					    <!--    </td>-->
					    <!--@endif-->
					</tr>
					<!-- Modal -->
                    <div class="modal fade" id="myModal{{$rec->id}}" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal"><b>&times;</b></button>
                                  <h4 class="modal-title"><b>Signature Below</b></h4>
                                </div>
                                <div class="modal-body">
                                    <canvas id="myCanvas{{$rec->id}}" width="400" height="400" style="border:2px solid;"></canvas>
                                    <div>Choose Color</div>
                                    <div style="width:10px;height:10px;background:green;" id="green" onclick="color(this)"></div>
                                    <div style="width:10px;height:10px;background:blue;" id="blue" onclick="color(this)"></div>
                                    <div style="width:10px;height:10px;background:red;" id="red" onclick="color(this)"></div>
                                    <div style="width:10px;height:10px;background:yellow;" id="yellow" onclick="color(this)"></div>
                                    <div style="width:10px;height:10px;background:orange;" id="orange" onclick="color(this)"></div>
                                    <div style="width:10px;height:10px;background:black;" id="black" onclick="color(this)"></div>
                                    <div>Eraser</div>
                                    <div style="width:15px;height:15px;background:white;border:2px solid;" id="white" onclick="color(this)"></div>
                                    <img id="canvasimg" style="display:none;">
                                    <input type="button" value="save" id="btn" size="30" onclick="save()">
                                    <input type="button" value="clear" id="clr" size="23" onclick="erase()">
                                </div>
                                <div class="modal-footer">
                                  <a class="btn btn-md btn-success" href="{{ URL::to('/') }}/confirmDelivery?id={{ $rec->id }}&projectId={{ $rec->project_id }}">Confirm Delivery</a>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
					@endforeach
				</tbody>	
			</table>
			<br>
			<center>{{$view->links()}}</center>	
		</div>
	</div>
</div>
<script type="text/javascript">
    var canvas, ctx, flag = false,
        prevX = 0,
        currX = 0,
        prevY = 0,
        currY = 0,
        dot_flag = false;

    var x = "black",
        y = 2;
    
    function init(arg) {
        canvas = document.getElementById(arg);
        ctx = canvas.getContext("2d");
        w = canvas.width;
        h = canvas.height;
    
        canvas.addEventListener("mousemove", function (e) {
            findxy('move', e)
        }, false);
        canvas.addEventListener("mousedown", function (e) {
            findxy('down', e)
        }, false);
        canvas.addEventListener("mouseup", function (e) {
            findxy('up', e)
        }, false);
        canvas.addEventListener("mouseout", function (e) {
            findxy('out', e)
        }, false);
    }
    
    function color(obj) {
        switch (obj.id) {
            case "green":
                x = "green";
                break;
            case "blue":
                x = "blue";
                break;
            case "red":
                x = "red";
                break;
            case "yellow":
                x = "yellow";
                break;
            case "orange":
                x = "orange";
                break;
            case "black":
                x = "black";
                break;
            case "white":
                x = "white";
                break;
        }
        if (x == "white") y = 14;
        else y = 2;
    
    }
    
    function draw() {
        ctx.beginPath();
        ctx.moveTo(prevX, prevY);
        ctx.lineTo(currX, currY);
        ctx.strokeStyle = x;
        ctx.lineWidth = y;
        ctx.stroke();
        ctx.closePath();
    }
    
    function erase() {
        var m = confirm("Want to clear");
        if (m) {
            ctx.clearRect(0, 0, w, h);
            document.getElementById("canvasimg").style.display = "none";
        }
    }
    
    function save() {
        document.getElementById("canvasimg").style.border = "2px solid";
        var dataURL = canvas.toDataURL();
        document.getElementById("canvasimg").src = dataURL;
        document.getElementById("canvasimg").style.display = "inline";
    }
    
    function findxy(res, e) {
        if (res == 'down') {
            prevX = currX;
            prevY = currY;
            currX = e.clientX - canvas.offsetLeft;
            currY = e.clientY - canvas.offsetTop;
    
            flag = true;
            dot_flag = true;
            if (dot_flag) {
                ctx.beginPath();
                ctx.fillStyle = x;
                ctx.fillRect(currX, currY, 2, 2);
                ctx.closePath();
                dot_flag = false;
            }
        }
        if (res == 'up' || res == "out") {
            flag = false;
        }
        if (res == 'move') {
            if (flag) {
                prevX = currX;
                prevY = currY;
                currX = e.clientX - canvas.offsetLeft;
                currY = e.clientY - canvas.offsetTop;
                draw();
            }
        }
    }
    </script>

<script type="text/javascript">
	
	function pay(arg)
	{
		var e = document.getElementById("selectPayment-"+arg);
		var strUser = e.options[e.selectedIndex].value;
		var ans = confirm('Are You Sure ? Note: Changes Made Once CANNOT Be Undone');
		if(ans){
			$.ajax({
				type: 'GET',
				url: "{{URL::to('/')}}/updateampay",
				data: {payment: strUser, id: arg},
				async: false,
				success: function(response){
					console.log(response);
				}
			});
		}
		return false;
	}

	function updateDispatch(arg)
	{
		var e = document.getElementById("selectdispatch-"+arg);
		var strUser = e.options[e.selectedIndex].value;
		var ans = confirm('Are You Sure ? Note: Changes Made Once CANNOT Be Undone');
		if(ans){
    		$.ajax({
    			type: 'GET',
    			url: "{{URL::to('/')}}/updateamdispatch",
    			data: {dispatch: strUser, id: arg},
    			async: false,
    			success: function(response){
    				console.log(response);	
    			}
    		});
		}
		return false;	
	}
	
	function confirmOrder(arg)
	{
	    var ans = confirm('Are You Sure To Confirm This Order ?');
	    if(ans)
	    {
    	    $.ajax({
    	       type:'GET',
    	       url: "{{URL::to('/')}}/confirmOrder",
    	       data: {id : arg},
    	       async: false,
    	       success: function(response)
    	       {
    	           console.log(response);
    	           location.reload(true);
    	       }
    	    });
	    }    
	}
	
	function cancelOrder(arg)
	{
	    var ans = confirm('Are You Sure To Cancel This Order ?');
	    if(ans)
	    {
    	    $.ajax({
    	       type:'GET',
    	       url: "{{URL::to('/')}}/cancelOrder",
    	       data: {id : arg},
    	       async: false,
    	       success: function(response)
    	       {
    	           console.log(response);
    	           location.reload(true);
    	       }
    	    });
	    }
	 }

</script>
@endsection