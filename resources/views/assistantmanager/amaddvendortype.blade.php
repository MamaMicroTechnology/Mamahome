<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 8? "layouts.app":"layouts.amheader");
?>
@extends($ext)
@section('content')
<div class="col-md-10 col-md-offset-1" style="background-color:white">
    <br>
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <b style="color:white;text-align:center">Add Vendor</b>
                </div>
                <div class="panel-body">
                    @if(Auth::user()->group_id != 8)
                    <form method="POST" action="{{URL::to('/')}}/amaddvendor">
                        @else
                         <form method="POST" action="{{URL::to('/')}}/marketingaddvendor">
                            @endif
                        {{ csrf_field() }}
                        <table class="table table-responsive table-striped">
                            <tbody>
                                <tr>
                                    <td style="width:30%">Vendor Type : </td>
                                    <td style="width:70%"><input type="text" class="form-control" id='vendor' name='vendor' /></td>
                                </tr>
                                <tr>
                                    
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <input type="submit" class="btn btn-md btn-primary" name='submit' id='submit' value="Add Vendor" /> &nbsp;&nbsp;
                            <input type="reset" class="btn btn-md btn-danger" value="Clear" />
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default" style="border-color:green">
                <div class="panel-heading text-center" style="background-color:green">
                    <b style="color:white">Vendor Types</b>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-striped">
                        <tbody>
                            @foreach($vendor as $ven)
                            <tr ><td class="text-center">{{$ven->vendor_type}}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
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
@endsection