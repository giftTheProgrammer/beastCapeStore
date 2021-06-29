@extends('layouts.app')

@section('content')
    <h1>Artworks</h1>
    @if(count($artworks) > 0)
    	@foreach($artworks as $artwork)
	        <ul>
	            <li><img src="{{URL::asset('storage/photos/'.$artwork->artwork_thumbnail)}}" height="450" width="320"></li>
	        </ul>
        @endforeach
    @endif
@endsection