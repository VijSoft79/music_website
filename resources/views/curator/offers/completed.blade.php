@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Completed Invitations ({{ \App\Models\Offer::getInvitationcount(2) }})</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <livewire:curator.offers-list :status="2" />
            </div>
        </div>
    </div>
@stop
