@extends('layouts.app')

@section('content')
    <h1 class="heading">Artworks</h1>
    <div class="display-body">
    	@if(count($artworks) > 0)
    		<ul class="row">
		    	@foreach($artworks as $artwork)
			        
			        <li class="col-lg-2">
			           	<div class="card">
			           		<a href="/show/{{$artwork->id}}" class="art-pic">
			            		<img src="{{URL::asset('storage/photos/'.$artwork->artwork_thumbnail)}}" class="card-img-top" />
			            	</a>
			            	<div class="card-body">
			            		<h2 class="card-title">{{ $artwork->title }}</h2>
			            		<h3 id="the-money" class="card-text"><strong>R{{ $artwork->artwork_price }}</strong></h3>
			            		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-play-btn" viewBox="0 0 16 16">
								  <path d="M6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814l-3.5-2.5z"/>
								  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
								</svg>
			            		<!--
			            		<audio id="play">
			            			<source src="{{URL::asset('storage/songs/'.$artwork->mainfile)}}" type="audio/mpeg" />
			            		</audio>
			            		-->
			            	</div>
			            </div>
			        </li>
			        
		        @endforeach
	        </ul>
    	@endif
    </div>
    
@endsection