@extends('adminlte::page')

@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>{{ Auth::user()->name }} In Progress Invitations List</h1>
@stop

@section('content')
    <div class="container-fluid">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <livewire:musician.invitation-list :status="1">
    </div>
@stop
