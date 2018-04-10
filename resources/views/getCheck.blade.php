@extends('layouts.app')

@section('content')
<div class="col-md-3"></div>
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><b>File Should be in PDF Format</b>
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
                        		
                        				<a href="{{ URL::to('/')}}/hrfiles/{{ strtolower($list->upload)}} " class="btn btn-sm btn-primary" target="_blank">View file</a>
                        			
                        		</td>
                        		<td>
                        			<a href="{{ URL::to('/')}}/hrfiles/{{ $list->upload}} " class="btn btn-sm btn-success" target="_blank">Download</a>
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