@extends('layouts.email-header')

@section('content')
    <h2>Hi, {{$musician}}</h2>

    <p>{!! $content !!}</p>
@endsection
