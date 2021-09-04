@extends('layouts.app')

@section('content')
	@if(count($myworks) > 0)
		<ul>
			@foreach($myworks as $mywork)
				<li>{{$mywork->title}}</li>
			@endforeach
		</ul>
	@else
		<h2>You have not submitted anything yet.</h2>
	@endif
@endsection