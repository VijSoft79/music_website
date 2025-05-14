@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ $offer->music->title }}
        ({{ $offer->offer_type ?? 'Unselected Offer' }})</h1>
@stop

@section('content')
<div class="row">
    <div class="col-8 mx-auto my-5">
        <livewire:chat-box :offer="$offer" class="my-5"/>
    </div>
</div>

    
@stop
