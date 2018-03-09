@extends('layouts.buyerlayout')
@section('title','My Profile')
@section('content')
<div class="col-md-12">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading text-center" style="background-color: black">
                <b style="color:white;font-size:1.3em">My Profile</b>
            </div>
            <div class="panel-body">
                @if(SESSION('success'))
                    <div class="text-center">
                        <span style="color:green;font-size:1.3em">{{SESSION('success')}}</span>
                    </div>
                @endif
                <form method="POST" action="{{URL::to('/')}}/updateProfile">
                    {{csrf_field()}}
                    <table class="table table-responsive table-striped">
                        <br>
                        <tbody>
                            <tr>
                                <td style="width:40%;padding-left:10%;padding-top:1.5%"><b>Name : </b></td>
                                <td><input class="form-control" value="{{$view->name}}" name="name" id="name" /></td>
                            </tr>
                            <tr>
                                <td style="width:30%;padding-left:10%;padding-top:1.5%"><b>Email : </b></td>
                                <td><input class="form-control" value="{{$view->email}}" name="email" id="email" /></td>
                            </tr>
                            <tr>
                                <td style="width:30%;padding-left:10%;padding-top:1.5%"><b>Contact Number : </b></td>
                                <td><input class="form-control" value="{{$view->contactNo}}" name="contactNo" id="contactNo" /></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-md btn-success" style="width:40%"/>
                        <input type="reset" value="Reset" class="btn btn-md btn-warning" style="width:40%" />
                    </div>
                </form>    
            </div>
        </div>
    </div>
</div>
    
@endsection