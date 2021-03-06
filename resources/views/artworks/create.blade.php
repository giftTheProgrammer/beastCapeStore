@extends('layouts.app')

@section('content')
	<div class="container">
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
			<div class="form-group">
				{{ Form::label('artwork_type', 'Type') }}<br />
				{{ Form::select('artwork_type', ['music' => 'Music', 'book' => 'Book'], null, ['class' => 'form-control']) }}
			</div>
			
			<br />
			<div class="form-group">
				{{ Form::label('title', 'Title') }}<br />
				{{ Form::text('title', '', ['class' => 'form-control']) }}
			</div>
			<br />

			<div class="form-group">
				{{ Form::label('artist', 'Artist') }}
				{{ Form::text('artist', $artist->moniker, ['class' =>  'form-control', 'readonly']) }}
			</div>
			<br />

			<div class="form-group">
				{{ Form::label('artist_id', 'ArtistID') }}
				{{ Form::text('artist_id', $artist->id, ['class' => 'form-control', 'readonly']) }}
			</div>

			<div class="form-group">
				{{ Form::label('description', 'Song Description') }}
				{{ Form::textarea('description', '', ['class' => 'form-control']) }}
			</div>
			<br />

			<div class="form-group">
				{{ Form::label('price', 'Price') }}<br />
				{{ Form::text('price', '', ['class' => 'form-control']) }}
			</div>
			<br />
			
			<div class="custom-file">
				{{ Form::file('thumbnail_dir', ['class' => 'custom-file-input']) }}
				{{ Form::label('thumbnail_dir', 'Thumbnail', ['class' => 'custom-file-label']) }}
			</div>
			<br /><br />
			<div class="custom-file">
				{{ Form::file('audiofile_dir', ['class' => 'custom-file-input']) }}
				{{ Form::label('audiofile_dir', 'Upload Your Song', ['class' => 'custom-file-label']) }}
			</div>
			<br /><br />
			<div class="form-group">
				{{ Form::submit('Submit', ['class' => 'btn btn-success', 'id' => 'btn']) }}
			</div>
		{!! Form::close() !!}
	</div>
	

	<script type="text/javascript">
		$(document).ready(function(){
			$(".custom-file-input").on("change", function(){
		        var fileName = $(this).val().split("\\").pop();
		        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		    });
		});
    </script>
		

@endsection