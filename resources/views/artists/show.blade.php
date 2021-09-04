@extends('layouts.app')

@section('content')
 <img height="512" width="360" src="{{URL::asset('/storage/photos/profiles/'.$artist->profile_pic)}}" />
 <a href="/artworks/viewArtist/{{$artist->id}}" class="btn btn-light">My Works</a>
 <a href="/create/{{$artist->id}}/" class="btn btn-success">Submit an item</a>
@endsection