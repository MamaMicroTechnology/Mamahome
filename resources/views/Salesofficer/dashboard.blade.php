@extends('layouts.app')
@section('content')
<div style="background-color:white" class="container" >
<h2 ><center>WELCOME TO  SALES OFFICER
<br>ZONE 1, BANGALORE'S DASHBOARD
<BR><BR>
    <SMALL>You must know your responsibilities and carry out your tasks responsibly.<br>
    We appreciate you services.
    </SMALL>
    <h3>Your Assigned Category Name : {{$catname}}
</center></h2></div>
@if(session('Success'))
<script>
    swal("success","{{ session('Success') }}","success");
</script>
@endif
@if(session('error'))
<script>
    swal("success","{{ session('error') }}","success");
</script>
@endif
@if(session('earlylogout'))
  <div class="modal fade" id="emplate" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #f27d7d;color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Early logout</h4>
        </div>
        <div class="modal-body">
          <p style="text-align:center;">{!! session('earlylogout') !!}</p>  
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
<div class="col-md-2">
                 <h4><b></b></h4>
                 @foreach($categories as $category)
                  <button onclick="brands('{{ $category->id}}')">{{ $category->category_name }}</button>
                  @endforeach
                </div>
                <div class="col-md-2">
                  <h4><b></b></h4>
                    <div id="brands2"></div>
                </div>
                 <div class="col-md-2">
                   <h4><b></b></h4>
                     <div id="sub2"></div>
                </div>
                <script type="text/javascript">
  var category;
function brands(arg){
 
        // var e = document.getElementById('category2');
        // var cat = e.options[e.selectedIndex].value;
        var ans = "";
        category = arg;
        $("html body").css("cursor", "progress");
        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getBrands",
            async:false,
            data:{cat : arg },
            success: function(response)
            {
                console.log(response);
               
                for(var i=0;i<response[0].length;i++)
                {
                    var text = "<button class='form-control' btn btn-warning btn-sm' onclick=\"Subs(\'" + response[0][i].id + "\')\">" + response[0][i].brand+"</button><br>";
                    ans += text;
                }
                document.getElementById('brands2').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
    }
function Subs(arg)
    {
        var ans = "";

        $.ajax({
            type:'GET',
            url:"{{URL::to('/')}}/getSubCatPrices",
            async:false,
            data:{brand : arg, cat: category},
            success: function(response)
            {
                var ans = " ";

                for(var i=0;i<response[1].length;i++)
                {
                     ans += "<button class='form-control btn btn-default btn-sm' value='"+response[1][i].id+"'>"+response[1][i].sub_cat_name+"</button><br><br>";
                   
                }

                document.getElementById('sub2').innerHTML = ans;
                $("body").css("cursor", "default");
            }
        });
    }
</script>
@endsection