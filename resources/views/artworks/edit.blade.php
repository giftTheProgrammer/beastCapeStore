@extends('layouts.app')

@section('content')
	<a href="/home" class="btn btn-outline-dark">Back</a>
	<h1>Edit Song</h1>

	@if($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	{!! Form::open(['action' => ['ArtworksController@update', $artwork->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'file' => true]) !!}
		{{ Form::label('artwork_type', 'Type') }}<br />
		{{ Form::select('artwork_type', ['music' => 'Music', 'book' => 'Book']) }}
		<br /><br />
		{{ Form::label('title', 'Title') }}<br />
		{{ Form::text('title', $artwork->title) }}
		<br /><br />
		{{ Form::label('price', 'Price') }}<br />
		{{ Form::text('price', $artwork->artwork_price) }}
		<br /><br />
		{{ Form::label('thumbnail_dir', 'Thumbnail') }}<br />
		{{ Form::file('thumbnail_dir') }}
		<br /><br />
		{{ Form::label('audiofile_dir', 'Upload Your Song') }}<br />
		{{ Form::file('audiofile_dir') }}
		<br /><br />
		{{ Form::hidden('_method', 'PUT') }}
		{{ Form::submit('Submit', ['class' => 'btn', 'id' => 'btn']) }}
	{!! Form::close() !!}
@endsection