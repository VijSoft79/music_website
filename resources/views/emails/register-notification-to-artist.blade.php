@extends('layouts.email-header')

@section('content')
    <h2>Welcome to Youhearus!</h2>
    <p>Hi there, {{ $name }}</p>
    <p>{!! $content !!}</p>
    {{-- <br>
    <p style="color:#fff">{!! $content !!}</p>
    <br>
    <p>Please verify your email</p>
    <br>
    <a href="{{$url}}" style=" border: 1px solid black; padding: 12px; color:#fff; margin-bottom:10px">click here to verify</a> --}}
@endsection