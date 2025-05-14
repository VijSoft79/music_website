@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container">
        <h1>{{ Auth::user()->name }} Playlist</h1>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <a href="{{ route('spotify.logout') }}">Log out of Spotify</a>
            <div class="col-12">
                @if ($playlists)
                    @foreach ($playlists as $playlist)
                        <div class="row border rounded p-2 mb-2" style="border-width: 3px !important">
                            <div class="col-2 border-right">
                                @if (isset($playlist['images'][0]['url']))
                                    <img src="{{ $playlist['images'][0]['url'] }}" alt="{{ $playlist['name'] }}" width="100">
                                @else
                                    <img src="https://via.placeholder.com/100" alt="No Image" width="100">
                                @endif
                            </div>
                            <div class="col border-right">
                                <h3>{{ $playlist['name'] }}</h3>
                            </div>
                            <div class="col">
                                <p>{{ $playlist['tracks']['total'] }} tracks</p>
                            </div>
                            <a href="{{ route('spotify.playlist', $playlist['id']) }}">go to playlist</a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop
