@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1 class="ml-2">Offer Information</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        
        <h3><b> {{$offer->offer_type}}</b></h3>
    </div>
    <div class="card-body">

        <dl>
            <dt>Music Title</dt>
            <dd>{{$offer->music->title}}</dd>

            <dt>Artist</dt>
            <dd>{{$offer->music->artist->name}}</dd>

            <dt>Artist Email:</dt>
            <dd>{{$offer->music->artist->email}}</dd>

            <dt class="mb-3">Press Release:</dt>
            @if ($offer->music->release_url)
                <a href="{{ asset('storage/' . $offer->music->release_url) }}" download="{{ $offer->music->press_release_download_filename }}">
                    <button class="btn btn-primary">Download File</button>
                </a>
                
            @else
                <dd>No Press Release</dd>
            @endif
            
        </dl>
    </div>
</div>
@stop