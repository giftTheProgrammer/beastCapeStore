@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>              
                @if (session('status'))
                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="display-body">
        @if(count($artworks) > 0)
            <table class="table-striped myworks">
                <thead>
                <tr>
                    <th></th>
                    <th class="table-titles">Song</th>
                    <th class="table-titles">Artist</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
             
                @foreach($artworks as $artwork)
                    <tr>
                        <td>
                            <a href="/show/{{ $artwork->id }}">
                                <img src="{{URL::asset('storage/photos/'.$artwork->artwork_thumbnail)}}" height="60" width="45" />
                            </a>
                        </td>
                        
                        <td class="artwork-title">{{ $artwork->title }}</td>
                        <td class="artwork-title">{{ $artwork->artist }}</td>
                        <td>
                            <audio controls id="play">
                                <source src="{{ URL::asset('/storage/songs/'.$artwork->mainfile) }}" type="audio/mpeg">
                            </audio>
                        </td>
                        <td class="st-size"><a href="/artworks/{{$artwork->id}}/edit" class="btn btn-warning">Edit</a></td>
                        <td class="st-size">
                            {!! Form::open(['action' => ['ArtworksController@destroy', $artwork->id], 'method' => 'POST']) !!}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @else
                <h2>You have no songs submitted yet.</h2>
            @endif
    </div>

@endsection
