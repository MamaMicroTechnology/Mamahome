
@extends('Layouts.app')

@section('content')
<div class="col-md-6">
    <div class="panel panel-default" style="border-color: green;">
                <div class="panel-heading" style="background-color:green; color:white;"><b>List of Documents to get from New Employee</b>
                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
                <div class="panel-body" style="colr">

                    <table class="table">
                        <tr> 
                        <td>Academic </td>
                        <td>Required Documents</td>
                        <td>Required Documents</td>
                        </tr>
                        <tr> 
                            <td>Bank</td>
                            <td>Required Documents</td>
                            <td>Bank account details</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>IFSC</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>A/C Details</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Email id</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Mobile number</td>
                        </tr>
                         <tr>
                            <td></td>
                            <td></td>
                            <td>Branch Name</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Pass Book</td>
                        </tr>
                        <tr> 
                            <td>Reference Contact Number</td>
                            <td>Reference Number</td>
                            <td>Friend</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Relatives</td>
                        </tr>
                        <tr> 
                            <td>Adsress Proof</td>
                             <td>Required Documents</td>
                             <td>Aadhar Card Photocopy</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Voter ID Card/Pan Card</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Blood Group</td>
                        </tr>
                        <tr> 
                            <td> If Applicable</td>
                             <td>Required Documents</td>
                             <td>Experience letter</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Salary Slip</td>
                        </tr>
                        <tr>
                        <td> Photos</td>
                        <td>Required Documents</td>
                        <td>Two passport size photos</td>
                         </tr>

                     </table>



                </div>
            </div>
    

</div>
<div class="col-md-6">
            <div class="panel panel-default" style="border-color: green;">
                <div class="panel-heading"  style="background-color:green; color:white;" ><b>File Should be in PDF Format</b>
                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
                <div class="panel-body">
<form method="POST" action="{{ URL::to('/') }}/uploadfile" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <table class="table">
                                <tr>
                                    <td><input type="text" name="name" required class="form-control input-sm" placeholder="Name">
                                    </td>
                                    <td><input type="file" name="upload" required class="form-control input-sm" accept="application/pdf">
                                    </td>
                                    
                                    <td><button type="submit" class="btn btn-success input-sm">Upload file</button></td>
                                </tr>
                            </table>
                        </form>
                        <form >
                            {{ csrf_field() }}
                            <table class="table">
                            	<thead>
                                    <th>Name</th>
                                    <th >Action</th>
                                    <th>Download</th>
                                    <th>Delete</th>
                                </thead>
                                <tbody>
                            	 @foreach($lists as $list)
                        		<tr>
                        		<td >{{ $list->name }} </td>
                        		<td >
                        		
                        				<a href="{{ URL::to('/')}}/public/hrfiles/{{ $list->upload }} " class="btn btn-sm btn-primary" target="_blank">View file</a>
                        			
                        		</td>
                        		<td>
                        			<a href="{{ URL::to('/')}}/public/hrfiles/{{ $list->upload}} " class="btn btn-sm btn-success" target="_blank" download>Download</a>
                        		</td>
                        		<td>
                        			<a href="{{ URL::to('/')}}/deletelist?id={{ $list->id }}" class="btn btn-sm btn-danger" >Delete</a>
                        		</td>
                       		 </tr>
                       		 @endforeach
                       		 </tbody>
                        </table>
                    </form>
            	</div>
			</div>
</div>
@endsection
