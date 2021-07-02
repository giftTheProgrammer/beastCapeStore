@extends('layouts.app');

@section('content')
	<h1>Sumbit an Artwork</h1>

	@if($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	{!! Form::open(['action' => 'ArtworksController@store', 'method' => 'POST', 'id' => 'form-edit', 'enctype' => 'multipart/form-data', 'file' => true]) !!}
		{!! Form::label('artwork_type', 'Type') !!}<br />
		{!! Form::select('artwork_type', ['music' => 'Music', 'book' => 'Book']) !!}
		<br /><br />
		{!! Form::label('title', 'Title') !!}<br />
		{!! Form::text('title') !!}
		<br /><br />
		{!! Form::label('price', 'Price') !!}<br />
		{!! Form::text('price') !!}
		<br /><br />
		{!! Form::label('thumbnail_dir', 'Thumbnail') !!}<br />
		{!! Form::file('thumbnail_dir') !!}
		<br /><br />
		{!! Form::submit('Submit', ['class' => 'btn', 'id' => 'btn']) !!}
	{!! Form::close() !!}
@endsection