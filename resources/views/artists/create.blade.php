@extends('layouts.app')

@section('content')
	@if($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		{!! Form::open(['action' => 'ArtistProfileController@store', 'method' => 'POST', 'id' => 'form-edit', 'enctype' => 'multipart/form-data', 'file' => true]) !!}
			<div class="form-group">
				{{ Form::label('name', 'Name') }}<br />
				{{ Form::text('name', '', ['class' => 'form-control']) }}
			</div>
			<br />

			<div class="form-group">
				{{ Form::label('moniker', 'Moniker') }}
				{{ Form::text('moniker', '', ['class' =>  'form-control']) }}
			</div>
			<br />

			<div class="form-group">
				{{ Form::label('artform', 'Artform') }}<br />
				{{ Form::select('artform', ['music' => 'Music', 'painting' => 'Painting', 'book' => 'Book', 'clothing' => 'Clothing'], null, ['class' => 'form-control']) }}
			</div>
			<br />

			<div class="custom-file">
				{{ Form::label('profile_pic', 'Choose a Profile Picture', ['class' => 'custom-file-label']) }}<br />
				{{ Form::file('profile_pic', ['class' => 'custom-file-input']) }}
			</div>
			<br /><br />

			<div class="form-group">
				{{ Form::label('short_bio', 'Short Biography') }}
				{{ Form::textarea('short_bio', '', ['class' => 'form-control']) }}
			</div>
			<br />
			
			<div class="form-group">
				{{ Form::label('fbhandle', 'Facebook') }}
				{{ Form::text('fbhandle', '', ['class' =>  'form-control']) }}
			</div>
			<br />
			<div class="form-group">
				{{ Form::label('instahandle', 'Instagram') }}
				{{ Form::text('instahandle', '', ['class' =>  'form-control']) }}
			</div>
			<br />
			<div class="form-group">
				{{ Form::label('twitterhandle', 'Twitter') }}
				{{ Form::text('twitterhandle', '', ['class' =>  'form-control']) }}
			</div>
			<br />
			<div class="form-group">
				{{ Form::label('linkedinhandle', 'LinkedIn') }}
				{{ Form::text('linkedinhandle', '', ['class' =>  'form-control']) }}
			</div>
			<br />
			<div class="form-group">
				{{ Form::label('pinhandle', 'Pinterest') }}
				{{ Form::text('pinhandle', '', ['class' =>  'form-control']) }}
			</div>
			<br />
			<div class="form-group">
				{{ Form::label('tthandle', 'TikTok') }}
				{{ Form::text('tthandle', '', ['class' =>  'form-control']) }}
			</div>
			<br />
			<br />
			<div class="form-group">
				{{ Form::submit('Submit', ['class' => 'btn btn-secondary', 'id' => 'btn']) }}
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