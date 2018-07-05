@extends('layouts.app')
@section('content')

<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color: green;color: white;padding-bottom: 20px;">Edit Asset Details
        <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
        </div>
        <div class="panel-body">
        	 @if (session('Success'))
                        <div class="alert alert-success">
                            {{ session('Success') }}
                        </div>
               @endif
        	@foreach($post as $post)
        	 <form method="POST" action="{{URL::to('/')}}/saveasset?Id={{ $post->id}}"  enctype="multipart/form-data">
        	 	{{csrf_field()}}
		        	
		            <table class="table table-responsive">
		            	<tbody>
		            		<tr>
		            			<td><label>Name</label></td>
		            			<td><input type="text" class="form-control" value="{{ $post->name}}" name="ename" style="width: 50%;"></td>
		            		</tr>
		            		<tr>
		            			<td><label>Serial No.</label></td>
		            			<td><input type="text" class="form-control" value="{{ $post->sl_no}}" name="serialno" style="width: 50%;"></td>
		            		</tr>
		            		<tr>
		            			<td><label>Asset Image</label></td>
		            			 <td><input  type="file" name="upload"  class="form-control" accept="image/*" style="width:60%" /></td>
		            		</tr>
		            		<tr>
		            			<td><label>Description</label></td>
		            			<td><input type="text" class="form-control" value="{{ $post->description}}" name="desc" style="width: 50%;"></td>
		            		</tr>
		            		<tr>
		            			<td><label>Company</label></td>
		            			<td><input type="text" class="form-control" value="{{ $post->company}}" name="cmp" style="width: 50%;"></td>
		            		</tr>
		            		<tr>
                                <td ><label>Purchased Date:</label></td>
                                <td ><input required type="date" name="tdate"  value="{{ $post->date}}" class="form-control" style="width:60%" /></td>
                            </tr>
                            <tr>
                                <td ><label> Bill:</label></td>
                                <td ><input type="file" name="bill"  class="form-control" accept="image/*" style="width:60%" /></td>
                            </tr>
		            		<tr>
		            			<td><label>Remark</label></td>
		            			<td><input type="text" class="form-control" value="{{ $post->remark}}" name="remark" style="width: 50%;"></td>
		            		</tr>
		            		<tr>
		            			<td ></td>
		            			<td ><button type="submit" class="btn btn-sm btn-success">Save</button></td>
		            		</tr>
		            	</tbody>
		            </table>
		           
		         </form>
		          @endforeach
         </div>
     </div>
 </div>
 @endsection