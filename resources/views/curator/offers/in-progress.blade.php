\@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>In Progress Invitations ({{ \App\Models\Offer::getInvitationcount(1) }})</h1>
@stop

@section('css')
    <style>
        .container-fluid {
            padding-bottom: 2rem;
        }
    </style>
@stop

@section('content')
    <div class="container-fluid">
        <livewire:curator.offers-list :status="1" />
    </div>
@stop
