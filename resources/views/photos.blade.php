@if($message = Session::get('success'))
<div class="alert alert-info alert-dismissible fade in" role="alert">
  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    	<span aria-hidden="true">×</span>
  	</button>
  	<strong>Success!</strong> {{ $message }}
</div>
@endif
<form  action="{{ URL::to('/') }}/photos"  enctype="multipart/form-data" method="POST">
  	{{ csrf_field() }}
  	<div class="form-group">
    	<label for="">Photo</label>
    	<input class="form-control" name="photo" type="file" />
    	<button type="submit">Upload</button>
  	</div>
</form>