@extends('layouts.amheader')
@section('title','KRA')
@section('content')
<form method="POST" id='frm' action="{{URL::to('/')}}/updatekra"></form>
<div class="col-md-12">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default" style="border-color:#f4811f">
			<div class="panel-heading" style="background-color:#f4811f">
				<b style="font-size: 1.3em;color: white">Edit KRA</b>
				<a href="{{url()->previous()}}" class="btn btn-sm btn-danger pull-right">Back</a>
			</div>
			<div class="panel-body">
				@if(SESSION('success'))
				<div class="text-center">
					<b style="color:green;font-size:2em;">{{SESSION('success')}}</b><br><br>
				</div>
				@endif
				<form method="POST" id='frm' action="{{URL::to('/')}}/updatekra">
					{{csrf_field()}}
				<input type="hidden" name="groupid" value="{{$kra[0]->group_id}}">
				<input type="hidden" name="deptid" value="{{$kra[0]->department_id}}">
				<table class='table table-responsive table-hover'>
					<tbody>
						<tr>
							<td style="width:30%">
								<b>Department :</b> 	
							</td>
							<td style="width:70%">
								{{$kra[0]->dept_name}}
							</td>
						</tr>
						<tr>
							<td>
								<b>Designation :</b> 
							</td>
							<td>
								{{$kra[0]->group_name}}
							</td>
						</tr>
						<tr>
							<td>
								<b>Role :</b>
							</td>
							<td>
								<textarea class="form-control" name="role" style="resize: none" cols="60" rows="4">{{$kra[0]->role}}</textarea>
							</td>
						</tr>
						<tr>
							<td>
								<b>Goal :</b>
							</td>
							<td>
								<textarea class="form-control" name="goal" style="resize: none" cols="60" rows="4">{{$kra[0]->role}}</textarea>
							</td>
						</tr>
						<tr>
							<td>
								<b>Key Result Area :</b>
							</td>
							<td>
								<textarea class="form-control" name="result" style="resize: none" cols="60" rows="4">{{$kra[0]->key_result_area}}</textarea>
							</td>
						</tr>
						<tr>
							<td>
								<b>Key Result Performance :</b>
							</td>
							<td>
								<textarea class="form-control" name="perf" style="resize: none" cols="60" rows="4">{{$kra[0]->key_performance_area}}</textarea>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="text-center">
					<input type="submit" class="btn btn-md btn-success" name="submit" id='submit' value="Submit" style="color:white;font-size:1.2em" />
					<input type="reset" name="reset" style="color:white;font-size:1.2em" class="btn btn-md btn-primary">
				
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection