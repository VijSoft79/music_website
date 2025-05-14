@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container">
        <h1>{{$playlist['name']}}</h1>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form action="{{ route('spotify.add') }}" method="post">
                            @csrf
                            <div class="row mb-3">
    
                                <div class="col-md-6">
                                    <x-adminlte-input name="musicName" label="Track URI" type="text" required/>
                                </div>

                                <div class="col-md-6">
                                    <x-adminlte-input name="pos" label="Track Position" type="number"  min="1" required/>
                                </div>
                            </div>
                            <div class="row mb-3">
    
                                <div class="col-md-6">
                                    <x-adminlte-input name="days" label="Days to Displayed" type="number" min="1" required/>
                                </div>
                                {{-- continue --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dropdown">Offer for: </label>
                                        @if ($offersMusic)
                                            <select class="form-control" id="dropdown" name="musicOffer">
                                                <option value="">Choose...</option>
                                                @foreach ($offersMusic as $item)
                                                    <option value="{{ $item[1] }}">{{ $item[0] }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <x-adminlte-input name="playlistId" type="text" value="{{$playlist['id']}}" hidden/>
                                </div>

                                
                            </div>

                            <div class="row">
                                <div class="col">
                                    <x-adminlte-button label="Submit" type="submit" theme="success" />
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
        {{-- <div class="row"> --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="py-2"><b>{{$playlist['name']}}</b></h3>
                </div>
                <div class="card-body">
                    <div class="col-12 " style="font-size: 20px;">
                        <ol type="1" class="text-center" style="display: grid; grid-template-columns: repeat(2, 1fr);">
                            @foreach ($playlist['tracks']['items'] as $music)

                                <li>{{$music['track']['name']}}</li>

                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
            
        {{-- </div> --}}
    </div>
@stop


