@extends('layouts.app')

@section('content')
	<a href="/">Back</a>
	<h1>{{$artwork->title}}</h1>
	<img src="{{URL::asset('storage/photos/'.$artwork->artwork_thumbnail)}}" height="360" width="280" />
	<h3 id="the-money"><strong>R{{ $artwork->artwork_price }}</strong></h3>
	<audio controls id="play">
		<source src="{{URL::asset('storage/songs/'.$artwork->mainfile)}}" type="audio/mpeg" />
	</audio>
	<button class="btn btn-primary">add to cart</button>
@endsection