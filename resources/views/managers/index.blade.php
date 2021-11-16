@extends('layouts.app')

@section('content')


<div class="home-body">
        @if(count($artworks) > 0)
            <table class="table-striped myworks">
                <thead>
                <tr>
                    <th></th>
                    <th class="table-titles">Song</th>
                    <th class="table-titles">Artist</th>
                    <th class="table-titles">Status</th>
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
                        <td class="artwork-title">{{ $artwork->status }}</td>
                        <td>
                            <audio controls id="play">
                                <source src="{{ URL::asset('/storage/songs/'.$artwork->mainfile) }}" type="audio/mpeg">
                            </audio>
                        </td>
                        <td class="st-size"><a href="/managers/{{$artwork->id}}/setStatus" class="btn btn-warning">Change Status</a></td>
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
            @endif
@endsection