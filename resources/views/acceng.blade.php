@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 ">
             
            <div class="panel panel-default" style="border-color:#0e877f">
                <div class="panel-heading" style="background-color:#0e877f;color:white;">Account Executive</div>
                <div class="panel-body">
                    
                     @foreach($accengs as $acceng)
                       <?php 
                            $content = explode(" ",$acceng->name);
                          
                            $con = implode("",$content);
                        ?>
                        <a id="{{ $con }}" class="list-group-item" href="#">{{ $acceng->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <iframe class="col-md-9 img img-thumbnail" style="height:800px;border-color: #0e877f" id="disp"></iframe>
        <!-- <div class="col-md-10" id="disp">

        </div> -->
    </div>
</div>

<script src="phoneno-all-numeric-validation.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
@foreach($accengs as $acceng)
                       <?php 
                            $content = explode(" ",$acceng->name);
                            $con = implode("",$content);
                        ?>
<script type="text/javascript">            
$(document).ready(function () {
	
    $("#{{ $con }}").on('click',function(){
        // $(document.body).css({'cursor' : 'wait'});
        var url = 
        $('#disp').attr('src',"{{ URL::to('/') }}/acceng/"+encodeURIComponent("{{ $acceng->name }}"));
        $("#disp2").load("{{ URL::to('/') }}/acceng/"+encodeURIComponent("{{ $acceng->name }}"), function(responseTxt, statusTxt, xhr){
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
        // $(document.body).css({'cursor' : 'default'});
    });
});



</script>
@endforeach

@endsection