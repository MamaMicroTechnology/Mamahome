@extends('layouts.app')
@section('content')

<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default" style="border-color:green">
<div class="panel-heading" style="background-color:green;font-weight:bold;font-size:1.3em;color:white;text-align: center;">Asset Acknowledgement Form</div>
<div class="panel-body">
	
		<center></center>
		<center>This form is an acknowledgement for MAMA HOME equipment use for Employees.</center>
		<br>
			 <table class="table table-responsive table-bordered"  align="center" style="width:45%;">
			 	<tbody>
			 		@foreach( $user as $user)
			 		<tr>
                    <td><label>Name</label></td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td><label>Designation</label></td>
                    <td>{{ $user->group->group_name }}</td>
                </tr>
                <tr>
                    <td><label>User-Id Of MMT</label></td>
                    <td>{{ $user->email }}</td>
                </tr>
			 		<tr>
			 			<td><label>Date of Joining</label></td>
			 			<td>{{ date('d-m-Y' , strtotime($user->date_of_joining)) }}</td>
			 		</tr>
			 		<tr>
			 			<td><label>Contact Number</label></td>
			 			<td>{{ $user->contactNo }}</td>
			 		</tr>
			 		@endforeach
			 		@foreach($info as $info)
			 		<tr>
			 			<td><label>Asset</label></td>
			 			<td> {{ $info->asset_type}}</td>
			 		</tr>
			 		@endforeach
			 	</tbody>
			 </table>
			 	
			 <p style="text-align: justify;">I, {{ $user->name }}, understand the guidelines and policies for MAMA HOME equipment use.  I will only be using MAMA HOME asses for business purposes only.  Any software or hardware installed is required to have prior approval before installation.  Upon my termination with MAMA HOME (whether voluntary or involuntary), I will return all above-mentioned assets within 24 hours.  Failure to do so will result in a penalty. In addition, I acknowledge that I will not receive my last pay check, unless I return the above-mentioned assets.  Should final pay check not cover expenses, MAMA HOME retains the right to file for reimbursement through court proceedings.</p>
			 
			 <br>
			 <br>
			<table class="table table-responsive">
			<tbody>
			 		
			 		
			 		<tr>
			 			<td><img style=" height:50px; width:100px;" src="empsignature/{{ $info->emp_signature}}" ></td>
			 			<td style="text-align: right;"><img style=" height:50px; width:100px;" src="managersignature/{{ $info->manager_signature}}" ></td>
			 		</tr>
			 	
				 	<tr>
				 		<td>Employee Signature:</td>
				 		<td style="text-align: right;">Signature Aproved By:</td>

			 		</tr>
			 </tbody>
			 </table>
</div>
</div>
</div>

@endsection