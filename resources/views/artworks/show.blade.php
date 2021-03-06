@extends('layouts.app')

@section('content')
	<div class="display-body">
		@guest
			<a href="/" class="btn btn-outline-dark">Back</a>
		@else
			<a href="{{ URL::route('home') }}" class="btn btn-outline-dark">Back</a>
		@endguest
		<h1>{{$artwork->title}}</h1>
		<div class="item">
			<img src="{{URL::asset('storage/photos/'.$artwork->artwork_thumbnail)}}" height="360" width="280" />
			
			<div class="item-details">
	           	<p>Title:</p>
	            <h2>{{ $artwork->title }}</h2>
	            <p>Artist:</p>
	            <h3>{{ $artwork->artist }}</h3>
	            <p>Description:</p>
	            <p>{{ $artwork->description }}</p>
	            <h3 id="the-money">R{{ $artwork->artwork_price }}</h3>
	            <audio controls id="play">
	                <source src="{{URL::asset('storage/songs/'.$artwork->mainfile)}}" type="audio/mpeg" />
	            </audio>
	            <button class="btn btn-primary">add to cart</button>
	            @if(!Auth::guest())
	            	@if(Auth::id() == $artwork->user_id)
			            <a href="/artworks/{{$artwork->id}}/edit" class="btn btn-primary">Edit</a>
			            {!! Form::open(['action' => ['ArtworksController@remove', $artwork->id], 'method' => 'POST']) !!}
							{{ Form::hidden('_method', 'DELETE') }}
							{{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
						{!! Form::close() !!}
		            @endif
	            @endif
	        </div>
		</div>
	</div>
@endsection