@extends('layouts.app')
@section('content')
<div class="row">
		<div class="col-md-10 col-md-offset-1">
	        <div class="panel panel-default">
	        	<div class="panel-heading">
	        		
	        	</div>

	        	<div class="panel-body">
	        		
	        		
	        		<div class="ticket-info">
	        		@foreach($data->ticket as $ticket)
	        			<p>{{ $ticket->message  }}</p>
		        		<p>Categry: {{ $ticket->cat }}</p>
		        		<p>
	        			Status: <span class="label label-danger">
	        				{{ $ticket->status }}
	        			</span>
    					
		        		</p>
		        		<p>Created on:{{ $ticket->created_at }} </p>
	        		</div>
                    @endforeach
	        		<hr>

	        		<div class="comments">
	        			
	        				<div>
	        					
	        						<span class="pull-right"></span>
	        					</div>

	        					<div class="panel panel-body">
	        								
	        					</div>
	        				</div>
	        			
	        		</div>

	        		<div class="comment-form">
		        		<form action="http://localhost:8000/api/comment" method="POST" class="form">
		        			{!! csrf_field() !!}
		        			@foreach($data->ticket as $ticket)
                           <input type="hidden" name="ticket_id" value="{{$ticket->id }}">
                           <input type="hidden" name="user_name" value="{{ $ticket->user_name }}">
		        			@endforeach
		        			<div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                <textarea rows="10" id="comment" class="form-control" name="comment"></textarea>

                                @if ($errors->has('comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                @endif
	                        </div>

	                        <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
	                        </div>
		        		</form>
		        		
	        	</div>
	        </div>
	    </div>
	</div>
	@endsection