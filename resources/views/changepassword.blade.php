@extends('layouts.leheader')

@section('content')

<div class="col-md-4 col-md-offset-4">
    <form method="POST" action="{{ URL::to('/') }}/postchangepassword">
        {{ csrf_field() }}
    <div class="panel panel-success">
        <div class="panel-heading">Please fill up the form
        @if(session('Error'))
        <p class="alert-danger pull-right"> {{ session('Error') }}</p>
        @endif
        </div>
        <div class="panel-body">
            <input type="password" name="oldPwd" required class="form-control" placeholder="Enter old password"><br>
            <input id="newPwd" type="password" name="newPwd" required class="form-control" placeholder="Enter new password"><br>
            <input id="reenter" name="newPwd2" oninput="pwdcheck()" type="password" required class="form-control" placeholder="Re-enter new password"><br>
            <div id="err"></div>
        </div>
        <div class="panel-footer">
            <input type="submit" value="Change Password" class="form-control btn btn-warning">
        </div>
    </div>
    </form>
</div>

<script type="text/javascript">
    function pwdcheck(){
        var newp = document.getElementById('newPwd').value;
        var repwd = document.getElementById('reenter').value;
        if(repwd == ""){
            document.getElementById('err').innerHTML = "";
        }
        if(newp != repwd){
            document.getElementById('err').innerHTML = "<p class=\"alert-danger\">Password didn't match</p>";
        }else{
            document.getElementById('err').innerHTML = "";
        }
    }
</script>

@endsection