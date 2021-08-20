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
			            		<!--
			            		<audio controls id="play">
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