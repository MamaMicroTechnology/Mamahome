<!DOCTYPE html>
<html>
<head>
	<title>siply</title>
</head>
<body>
	@foreach($users as $user)
		User Name: 
		{{ $user->name }} <br>
		Activities : <br>
		@foreach($noOfCalls[$user->id]['data'] as $activities)
			{{ $activities->description }}<br> {{ $activities->subject->project_id }} <br>
		@endforeach
	@endforeach
</body> 
</html>