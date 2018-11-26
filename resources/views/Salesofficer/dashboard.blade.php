@extends('layouts.app')
@section('content')

<div style="background-color:white" class="container" >
<h2 ><center>WELCOME TO  SALES OFFICER
<br>ZONE 1, BANGALORE'S DASHBOARD
<BR><BR>
    <SMALL>You must know your responsibilities and carry out your tasks responsibly.<br>
    We appreciate you services.
    </SMALL>
    <h3 class="w3-container w3-center w3-animate-bottom" style="animation-duration: 2s;">Your Assigned Category  : {{$catname}}
</center></h2></div><br><br>
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
<!-- <div class="col-md-2">
                <h4 style="color:rgb(69, 198, 246);"><b>Click Here To Get Your Brands And Sub Categories</b></h4><br>
                 @foreach($categories as $category)
                  <button class="button" onclick="brands('{{ $category->id}}')">{{ $category->category_name }}</button>
                 
                  @endforeach
                </div>
               
                <div class="col-md-2">
                  <h4><b></b></h4>
                    <div id="brands2" style="float:bottom;"></div>
                </div><br>
                 <div class="col-md-2">
                   <h4><b></b></h4>
                     <div id="sub2"></div>
                </div> -->
                
            <center>    <div class="col-md-4 col-md-offset-1 w3-container w3-center w3-animate-left" style="animation-duration: 2s;">
                  <h3> INSTRUCTION</h3>
                      <table border="1" class="table">
                        <thead>
                          <th>Total Projects</th>
                          <th>Updated Projects</th>
                          <th>Remaining Projects</th>
                          <th>Enquiry Added</th>
                          <th>Instructions</th>
                        </thead>
                        <tbody>
                          <td style="font-size:40px;width:50%;"><a href="{{ URL::to('/') }}/projectsUpdate">{{ $projects}}</a></td>
                          <td style="font-size:40px;"><a href="{{ URL::to('/') }}/projectsUpdate?update=updateproject">{{$updateprojects}}</a></td>
                          <?php 
                          $x = $projects - $updateprojects;
                          ?>
                          <td style="font-size:40px;"><a href="{{ URL::to('/') }}/projectsUpdate?unupdate=unupdate">{{ $x }}</a></td>
                          <td style="font-size:40px;"><a href="{{ URL::to('/') }}/enquirywise?salesenq=enq">{{ $enq }}</a></td>
                          <td style="width:50%;">{{$ins}}</td>
                        </tbody>
                        
                      </table>

                </div>

  <div class="col-md-4 col-md-offset-1 w3-container w3-center w3-animate-right" style="animation-duration: 2s;">
           <h3>MONTHLY REPORT</h3>
                      <table border="1" class="table">
                        <thead>
                          <th>Total Projects</th>
                          <th>Updated Projects</th>
                          <th>Remaining Projects</th>
                          <th>Enquiry Added</th>
                        </thead>
                        <tbody>
                          <td style="font-size:40px;"><a href="{{ URL::to('/') }}/projectsUpdate">{{ $projects}}</a></td>
                          <td style="font-size:40px;"><a href="{{ URL::to('/') }}/projectsUpdate?update1=updateproject1">{{$updateprojects1}}</a></td>
                          <?php 
                          $x = $projects - $updateprojects1;
                          ?>
                          <td style="font-size:40px;"><a href="{{ URL::to('/') }}/projectsUpdate?unupdate1=unupdate1">{{ $x }}</a></td>
                          <td style="font-size:40px;"><a href="{{ URL::to('/') }}/enquirywise?salesenq1=enq1">{{ $enq1 }}</a></td>
                        </tbody>
                        
                      </table>

                </div>





              </center>
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