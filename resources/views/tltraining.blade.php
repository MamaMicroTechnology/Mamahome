@extends('layouts.app')
@section('content')
<div class="">
	
	<div class="col-md-12">
		<div class="panel panel-default" style="border-color:green">
			 <div class="panel-heading" style="background-color: green;color:white;"><b>
			 Team Leader Training Video		
			 </b>
                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                    <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
                </div>
			<div class="panel-body">
				
                     <table class="table table-responsive" >
                     	
                            @foreach($video as $video)
							
									<div class="col-md-4 " style="border: solid 1px green;">
		    						<br>
									<video class="img img-responsive" controls controlslist="nodownload">
		                                      <source src="{{ URL::to('/') }}/public/trainingvideo/{{ $video->upload }}" type="video/mp4">
		                                      <source src="{{ URL::to('/') }}/public/trainingvideo/{{ $video->upload }}" type="video/ogg">
		                              
		                             </video><br>
		                              <center style="color: green;font-size:20px;">{{$video->remark }}</center>
		                           </div>
                             @endforeach
                              
                         	</table>
	       	</div>
	    </div>
	</div>
</div> 
                    
						
@endsection
