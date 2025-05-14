@extends('adminlte::page')

@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>{{ Auth::user()->name }} Pending Invitations Lists</h1>
@stop

@section('content')
    <div class="container-fluid">
        <livewire:musician.invitation-list :status="0">
    </div>
@stop
