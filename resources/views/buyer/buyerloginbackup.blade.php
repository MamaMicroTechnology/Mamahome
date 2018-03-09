@extends('layouts.buyerlayout')
@section('title','Login')
@section('content')
<br><br><br>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <img id="imageid" class="img img-responsive center-block" src='logo.png' />
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <p style="color: white">
                    <p style="color:#f58120;text-align:center;font-size:1.6em" ><b>Linking Construction Industry With</b></p>
                    <p style="color:#008000;text-align:center;font-size:1.6em" ><b>A Professional Approach…</b></p>
                    <br>
                    <p style="color:#f58120;text-align:center;font-size:1.3em" >Avoiding All The Middle Agents Between The Manufactures And Consumers , <br>We Help Reduce The Overall Cost.</p>
                    <br><br>
                    <p style="color:#008000;font-size:1.6em" ><b>Contact</b></p>
                    <label style="color:#f58120;font-size:1.1em">Phone : </label><label style="color:#008000">&nbsp;+91 - 911 063 6146</label>
                    <br>
                    <label style="color:#f58120;font-size:1.1em">Email : </label><label style="color:#008000">&nbsp;info@mamahome360.com</label>
                </p>
            </div>
            <div class="col-md-6">
                <form method="POST" action="{{ URL::to('/') }}/blogin">
                    {{ csrf_field() }}
                    <h3 style="color:#008000;text-align:center"><b>LOG IN</b></h3>
                    <table class="table table-responsive table-hover">
                        <tbody>
                            <tr>
                                <td style="width:20%">Email</td>
                                <td><input type="text" class="form-control" id="email" name="email" placeholder="Email Here..."></td>
                            </tr>
                            <tr>
                                <td style="width:20%">Password</td>
                                <td><input type="password" class="form-control" id="pw" name="password"  placeholder="Password Here..."></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <input type="submit" class="btn btn-md btn-default form-control " style="width:90%;background-color:green;color:white;font-weight:bold" value="LOG IN"><br><br>
                        <a class="btn btn-md btn-info form-control" href="{{URL::to('/')}}/register" style="width:90%;;font-weight:bold"/>REGISTER</a>
                    </div>           
                    <br><br>    
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    $( document ).ready(function() {
        document.title = 'Buyer Login';
        document.getElementById("loginpanel").style.opacity = "1";
    });

</script>    
@endsection