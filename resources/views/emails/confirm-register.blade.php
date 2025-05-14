@extends('layouts.email-header')

@section('content')
    <h1>Hi there {{ $registeredName }}</h1>
    <p>{!! $messagebody !!}</p>
@endsection
