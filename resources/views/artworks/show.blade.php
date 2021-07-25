@extends('layouts.app')

@section('content')
	<div class="display-body">
		@guest
			<a href="/" class="btn btn-outline-dark">Back</a>
		@else
			<a href="/home" class="btn btn-outline-dark">Back</a>
		@endguest
		<h1>{{$artwork->title}}</h1>
		<div class="item">
			<img src="{{URL::asset('storage/photos/'.$artwork->artwork_thumbnail)}}" height="360" width="280" />
			
			<div class="item-details">
	           	<p>Title:</p>
	            <h2>{{ $artwork->title }}</h2>
	            <p>Type:</p>
	            <h3>{{ $artwork->artwork_type }}</h3>
	            <h3 id="the-money"><strong>R{{ $artwork->artwork_price }}</strong></h3>
	            <audio controls id="play">
	                <source src="{{URL::asset('storage/songs/'.$artwork->mainfile)}}" type="audio/mpeg" />
	            </audio>
	            <button class="btn btn-primary">add to cart</button>
	            @if(!Auth::guest())
	            	@if(Auth::id() == $artwork->user_id)
			            <a href="/artworks/{{$artwork->id}}/edit" class="btn btn-primary">Edit</a>
			            <a href="/artworks/{{$artwork->id}}/edit" class="btn btn-primary">Delete</a>
		            @endif
	            @endif
	        </div>
		</div>
	</div>
@endsection