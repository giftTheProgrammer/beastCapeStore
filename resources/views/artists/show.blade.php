@extends('layouts.app')

@section('content')
	<div id="myAva">
		<img height="512" width="360" src="{{URL::asset('/storage/photos/profiles/'.$artist->profile_pic)}}" />
		<div class="artist-controls">
			<div id="control1">
				<a href="/artworks/viewArtist/{{$artist->id}}" class="btn btn-light">My Works</a>
			</div>
			<div id="control1">
				<a href="/create/{{$artist->id}}/" class="btn btn-success">Submit an item</a>
			</div>
		</div>
	</div>
 
@endsection