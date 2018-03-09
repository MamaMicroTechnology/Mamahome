@extends('layouts.buyerlayout')

@section('content')
<br><br>
<div class="container">
    <div class="col-md-8 col-md-offset-2" >
        <button id='buyerid' class="btn btn-md" onclick="viewbuyer()" style="background-color:rgba(249, 142, 55, 0.78);color: white;width:49%; "><b>BUYER</b></button>
        <button id='contid' class="btn btn-md" onclick="viewcont()" style="background-color:rgb(22, 138, 67);color: white;width:49%; "><b>CONTRACTOR</b></button>
    </div>
    <br>
    <hr>
    <div id="regpage">
    <div class="row">
    @if(session('Error'))
    <div class="alert alert-danger alert-dismissable fade in text-center col-md-8 col-md-offset-2">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> {{ session('Error')}}
    </div>
    @endif
    @if(session('Success'))
    <div class="alert alert-success alert-dismissable fade in text-center col-md-8 col-md-offset-2">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> {{ session('Success')}}
    </div>
    @endif    
    <!-- For Orange : rgba(249, 142, 55, 0.78); For Green :rgb(22, 138, 67);  -->
<form method="POST" onsubmit="return validateform()" action="{{ URL::to('/')}}/register"> 
{{ csrf_field() }}
<input type="hidden" name="category" id="category" />   
<input type="hidden" name="password" id="password" /> 
<div class="col-md-8 col-md-offset-2" align="center" style="border-radius: 5px;">
    <div class="panel panel-primary" >
        <div class="panel-heading" id="panel-head" style="padding:0.5% 1% 0.5% 1%;">
        <h4 id="panel-header" style="text-align:left;padding-left:2%"></h4>
        </div>
        <div class="panel-body" style="background-color:white">
            
            <table class="table table-responsive">
                <tbody>
                <tr>
                    <td> Name </td>
                    <td> : </td>
                    <td> <input type="text" autocomplete="off" name="name" id="name" class="form-control input-sm" placeholder="First Name" required style="width:90%"> </td>
                </tr>
                <tr>
                    <td> Mobile No </td>
                    <td> : </td>
                    <td> <input type="text" autocomplete="off" onkeyup="check('number')" name="number" id="number" class="form-control input-sm" placeholder="10 Digits Phone Number" maxlength="10" minlength="10" required style="width:90%" /> </td>
                </tr>
                <tr>
                    <td> Email </td>
                    <td> : </td>
                    <td> <input type="text" autocomplete="off" onblur="checkmail('email')" name="email" id="email" class="form-control input-sm" placeholder="Valid Email Address" required style="width:90%;"> </td>
                </tr>
                </tbody>
            </table>
            <p><input type="checkbox" name="agree" id="agree" checked>
             &nbsp;&nbsp;I agree to the <a href="https://mamahome360.com/doc/Terms.html" style="text-decoration: none;">Terms and Conditions </a></p><br><br>
            <div class="text-center">
                <input type="submit" name="cregister" id='cregister' class="btn btn-lg" style="width:20%; background-color: rgb(22, 138, 67);color:white">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a name="resetbtn" id='resetbtn' class="btn btn-lg" style="width:20%; background-color:rgba(249, 142, 55, 0.78);color:white;" href="{{URL::to('/')}}/blogin">Log In</a>
                <img id='image' src="" onerror = "show()">
            </div>  
        </div>
    </div>
</div>
</div>
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
   
</script>
<script type="text/javascript">
    
    $( document ).ready(function() {
        document.title = 'Buyer Login';
        document.getElementById('body').style.backgroundImage = "url('public/background2.jpg')";
        document.getElementById("loginpanel").style.backgroundImage = "1";
    });
    
    function show(){
        document.getElementById('buyerid').style.opacity = 0.99;
        document.getElementById('contid').style.opacity = 0.3;
        $('#panel-head').css('background', 'rgba(249, 142, 55, 0.78)');
        document.getElementById('image').style.display = 'none';
        document.getElementById('category').value = 'Buyer';  
        document.getElementById('panel-header').innerHTML = '<b>Buyer Registration</b>';     
    }
        
    function viewbuyer(){
        document.getElementById('category').value = 'Buyer';
        document.getElementById('buyerid').style.opacity = 0.99;
        document.getElementById('contid').style.opacity = 0.3;  
        document.getElementById('panel-header').innerHTML = '<b>Buyer Registration</b>'; 
        $('#panel-head').css('background', 'rgba(249, 142, 55, 0.78)');
    }

    function viewcont(){
        document.getElementById('panel-header').innerHTML = '<b>Contractor Registration</b>'; 
        document.getElementById('category').value = 'Contractor';
        document.getElementById('buyerid').style.opacity = 0.3;
        document.getElementById('contid').style.opacity = 0.99;
        $('#panel-head').css('background', 'rgb(22, 138, 67)');
    }

    function validateform(){ 
        var x = document.getElementById('name');
        var y = document.getElementById('number');
        var z = document.getElementById('email');
        if(document.getElementById('agree').checked == true)
        {
            if(x.value.length > 0 && y.value.length > 0 && z.value.length > 0 && y.value.length === 10 )
            { 
                var temp = x.value.substring(0, 3);
                temp += '_';
                temp += y.value.substring(y.value.length, y.value.length-3);
                document.getElementById('password').value = temp;
                //Change this to 'true'
                return true;
            }
            else if(x.value.length == 0){
                alert('Please Fill Out Name Field');
                return false;
            }
            else if(y.value.length == 0){
                alert('Please Fill Out Number Field');
                return false;
            }
            else if(z.value.length == 0){
                alert('Please Fill Out Email Field');
                return false;
            }
            else if(y.value.length !== 10){
                alert('Please Fill Out 10 Digits in Number field');
                y.value='';
                return false;
            }
        }
        else
        {
            alert('You Must Agree To The Terms And Conditions.');
            $('#resetbtn').click();
            return false;
        }
    }
    
    function checkmail(arg){
        var mail = document.getElementById(arg);
        if(mail.value.length > 0 ){
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail.value))  {  
                return true;  
            }  
            else{
                alert("Invalid Email Address!");  
                mail.value = '';
                document.getElementById(arg).focus();
            }
        }
        return false;
    }
    
    function check(arg){
        var input = document.getElementById(arg).value;
        if(isNaN(input)){
            while(isNaN(document.getElementById(arg).value)){
                var str = document.getElementById(arg).value;
                str     = str.substring(0, str.length - 1);
                document.getElementById(arg).value = str;
            }
        }
        else{
          input = input.trim();
          document.getElementById(arg).value = input;
        }
        return false;
    }        
</script>

@endsection