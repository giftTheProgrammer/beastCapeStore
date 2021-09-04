@extends('layouts.app')

@section('content')
	<div class="container">
		@if(count($artists) > 0)
			<div class="team">
				@foreach($artists as $artist)
					<div class="team_member">
						<div class="team_img">
							<a  href="/artists/show/{{$artist->id}}">
								<img height="128" width="96" src="{{URL::asset('storage/photos/profiles/'.$artist->profile_pic)}}" />
							</a>
						</div>
						
						<h3>{{$artist->moniker}}</h3>
						<p class="role">{{$artist->artform}}</p>
						<p>{{$artist->short_bio}}</p>
						<a href="/artists/show/{{$artist->id}}" class="btn btn-secondary">View profile</a>
						
					</div>
				@endforeach
			</div>
		@endif
	</div>
@endsection