@extends('layouts.email-header')

@section('content')
    <h2>Hi, {{Auth::user()->name}}</h2>

    <p>{!! $content !!}</p>
@endsection


