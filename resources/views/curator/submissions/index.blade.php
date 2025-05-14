@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Artist Submission</h1>
@stop

@section('content')
    @if (session('message'))
    <div class="col-12">
        <x-adminlte-alert theme="success" title="Success">
            {{ session('message') }}
        </x-adminlte-alert>
    </div>
    @endif
    
    <livewire:curator.submissions-list />
@stop

@section('css')
    @livewireStyles
    <style>
        .opacity-50 {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
@stop

@section('js')
    @livewireScripts
@stop