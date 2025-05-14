@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>chats</h1>
@stop

@section('content')
    <livewire:chat-inbox />

@stop
