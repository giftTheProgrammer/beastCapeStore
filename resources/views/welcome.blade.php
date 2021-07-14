@extends('layouts.app')

@section('content')
    <h1 class="heading">Artworks</h1>
    <div class="display-body">
    	@if(count($artworks) > 0)
    		<ul>
		    	@foreach($artworks as $artwork)
			        
			        <li class="arts">
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
			            	</div>
			            </div>
			        </li>
			        
		        @endforeach
	        </ul>
    	@endif
    </div>
    
@endsection