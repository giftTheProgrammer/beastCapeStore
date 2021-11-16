@extends('layouts.app')

@section('content')
<div class="container">
		<a href="{{ URL::route('home') }}" class="btn btn-outline-dark">Back</a>
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

		{!! Form::open(['action' => ['ArtworksController@approve', $artwork->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'file' => true]) !!}
			<div class="form-group">
				{{ Form::label('artwork_type', 'Type') }}
				{{ Form::text('artwork_type', $artwork->artwork_type, ['class' => 'form-control', 'readonly']) }}
			</div>
			<br /><br />

			<div class="form-group">
				{{ Form::label('title', 'Title') }}
				{{ Form::text('title', $artwork->title, ['class' => 'form-control', 'readonly']) }}
			</div>
			<br /><br />

			<div class="form-group">
				{{ Form::label('status', 'Status') }}
				{{ Form::select('status', ['current' => $artwork->status, 'Approved' => 'passed', 'rejected' => 'Declined'], null,['class' => 'form-control']) }}
			</div>
			<br /><br />

			<div class="form-group">
				{{ Form::label('artist', 'Artist') }}
				{{ Form::text('artist', $artwork->artist, ['class' =>  'form-control', 'readonly']) }}
			</div>
			<br />

			<div class="form-group">
				{{ Form::label('description', 'Song Description') }}
				{{ Form::textarea('description', $artwork->description, ['class' => 'form-control', 'readonly']) }}
			</div>
			<br />

			<div class="form-group">
				{{ Form::label('price', 'Price') }}
				{{ Form::text('price', $artwork->artwork_price, ['class' => 'form-control', 'readonly']) }}
			</div>
			<br /><br />

			<div class="custom-file">
				{{ Form::label('thumbnail_dir', 'Thumbnail', ['class' => 'custom-file-label']) }}<br />
				{{ Form::file('thumbnail_dir', ['class' => 'custom-file-input', 'readonly']) }}
			</div>
			<br /><br />

			<div class="custom-file">
				{{ Form::label('audiofile_dir', 'Upload Your Song', ['class' => 'custom-file-label']) }}<br />
				{{ Form::file('audiofile_dir', ['class' => 'custom-file-input', 'readonly']) }}
			</div>
			<br /><br />

			<div class="form-group">
				{{ Form::hidden('_method', 'PUT') }}
				{{ Form::submit('Submit', ['class' => 'btn btn-primary', 'id' => 'btn']) }}
			</div>
			
		{!! Form::close() !!}
	</div>
@endsection