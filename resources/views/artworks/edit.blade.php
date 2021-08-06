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
		<div class="form-group">
			{{ Form::label('artwork_type', 'Type') }}
			{{ Form::select('artwork_type', ['music' => 'Music', 'book' => 'Book'], null, ['class' => 'form-control']) }}
		</div>
		<br /><br />

		<div class="form-group">
			{{ Form::label('title', 'Title') }}
			{{ Form::text('title', $artwork->title, ['class' => 'form-control']) }}
		</div>
		<br /><br />

		<div class="form-group">
			{{ Form::label('price', 'Price') }}
			{{ Form::text('price', $artwork->artwork_price, ['class' => 'form-control']) }}
		</div>
		<br /><br />

		<div class="custom-file">
			{{ Form::label('thumbnail_dir', 'Thumbnail', ['class' => 'custom-file-label']) }}<br />
			{{ Form::file('thumbnail_dir', ['class' => 'custom-file-input']) }}
		</div>
		<br /><br />

		<div class="custom-file">
			{{ Form::label('audiofile_dir', 'Upload Your Song', ['class' => 'custom-file-label']) }}<br />
			{{ Form::file('audiofile_dir', ['class' => 'custom-file-input']) }}
		</div>
		<br /><br />

		<div class="form-group">
			{{ Form::hidden('_method', 'PUT') }}
			{{ Form::submit('Submit', ['class' => 'btn btn-primary', 'id' => 'btn']) }}
		</div>
		
	{!! Form::close() !!}

	<script type="text/javascript">
		$(document).ready(function(){
			$(".custom-file-input").on("change", function(){
		        var fileName = $(this).val().split("\\").pop();
		        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		    });
		});
    </script>
@endsection