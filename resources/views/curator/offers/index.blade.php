@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Pending Invitations ({{ \App\Models\Offer::getInvitationcount(0, [], true) }})</h1>
@stop

@section('content')
    <div class="container-fluid">
        @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        <livewire:curator.offers-list :status="0" />
    </div>
@stop
