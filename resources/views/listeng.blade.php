@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
             
            <div class="panel panel-default" style="border-color:#0e877f">
                <div class="panel-heading" style="background-color:#0e877f">List Engineer</div>
                <div class="panel-body">
                    
                     @foreach($listengs as $listeng)
                       <?php 
                            $content = explode(" ",$listeng->name);
                          
                            $con = implode("",$content);
                        ?>
                        <a id="{{ $con }}" class="list-group-item" href="#">{{ $listeng->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-10" id="disp">

        </div>
    </div>
</div>

<script src="phoneno-all-numeric-validation.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
@foreach($listengs as $listeng)
                       <?php 
                            $content = explode(" ",$listeng->name);
                            $con = implode("",$content);
                        ?>
<script type="text/javascript">            
$(document).ready(function () {
	
    $("#{{ $con }}").on('click',function(){
        $(document.body).css({'cursor' : 'wait'});
        $("#disp").load("{{ URL::to('/') }}/listeng/"+encodeURIComponent("{{ $listeng->name }}"), function(responseTxt, statusTxt, xhr){
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
        $(document.body).css({'cursor' : 'default'});
    });
});



</script>
@endforeach

@endsection