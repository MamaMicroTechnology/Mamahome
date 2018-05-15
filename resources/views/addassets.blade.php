@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            @if(session('Added'))
                <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('Added') }}
                </div>
            @endif
            @if(session('NotAdded'))
               <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   {{ session('NotAdded') }}
                </div>
            @endif
            <button class="btn btn-default form-control" data-toggle="modal" data-target="#addEmployee" style="background-color:green;color:white;font-weight:bold">Add Asset Type</button>
            <br><br>
            <div class="panel panel-default" style="border-color:#f4811f">
                <div class="panel-heading" style="background-color:#f4811f;text-align: center;"><b style="font-size:1.3em;color:white;">Assets</b></div>
                <div class="panel-body" style="overflow-x: hidden;overflow-y: scroll;">
                    @foreach($assets as $asset)
                        <?php 
                            $content = explode(" ",$asset->type);
                            $con = implode("",$content);
                        ?>
                        <a id="{{ $con }}" class="list-group-item" href="#">{{ $asset->type }} ({{ $asts[$asset->type] }})</a>
                    @endforeach
                   
                </div>
            </div>
        </div>
        <div class="col-md-10" id="disp">

        </div>
    </div>
</div>
<!--Modal-->
<form method="post" action="{{ URL::to('/') }}/addtype">
    {{ csrf_field() }}
  <div class="modal fade" id="addEmployee" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#f4811f;color:white;fon-weight:bold">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Asset Type</h4>
        </div>
        <div class="modal-body">
           <table class="table table-responsive table-hover">
                        <tbody>
                            <tr>
                                <td style="width:30%"><label>   Asset Name: </label></td>
                                <td style="width:50%"><input type="text" required name="aname" placeholder=" Asset name"  class="form-control" style="width:50%" /></td>
                            </tr>
                        </tbody>
                </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>
<div class='b'></div>
<div class='bb'></div>
<div class='message'>
  <div class='check'>
    &#10004;
  </div>
  <p>
    Success
  </p>
  <p>
    @if(session('Success'))
    {{ session('Success') }}
    @endif
  </p>
  <button id='ok'>
    OK
  </button>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
@foreach($assets as $asset)
<?php 
    $content = explode(" ",$asset->type);
    $con = implode("",$content);
?>
<script type="text/javascript">
$(document).ready(function () {
    $("#{{ $con }}").on('click',function(){
        
        $(document.body).css({'cursor' : 'wait'});
        $("#disp").load("{{ URL::to('/') }}/viewasset?asset="+encodeURIComponent("{{ $asset->type }}"), function(responseTxt, statusTxt, xhr){
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });

        $(document.body).css({'cursor' : 'default'});
    });
});

</script>

@endforeach



@endsection
