@extends('layouts.app')

@section('content')
	@if(count($myworks) > 0)
		<table class="table table-striped table-dark">
			<tr>
				<th></th>
				<th>Title</th>
				<th>Artist</th>
				<th>Price</th>
				<th>Status</th>
				<th></th>
				<th></th>
			</tr>
			@foreach($myworks as $mywork)
				<tr>
					<td><img height="64" width="48" src="{{URL::asset('storage/photos/'.$mywork->artwork_thumbnail)}}"></td>
					<td>{{$mywork->title}}</td>
					<td>Moniker</td>
					<td>{{$mywork->artwork_price}}</td>
					<td>{{$mywork->status}}</td>
					<td><a href="/artworks/{{$mywork->id}}/edit/" class="btn btn-primary">Edit</a></td>
					<td>
						{{Form::open(['action' => ['ArtworksController@destroy', $mywork->id],'method' => 'POST'])}}
						{{Form::hidden('_method', 'DELETE')}}
						{{Form::submit('DELETE', ['class' => 'btn btn-danger'])}}
						{{Form::close()}}
					</td>
				</tr>
			@endforeach
		</table>
		<a href="/create/{{$mywork->artist_id}}/" class="btn btn-secondary">Submit an Item</a>
	@else
		<h2>You have not submitted anything yet.</h2>
	@endif
@endsection