@extends('layouts.email-header')

@section('content')
<h2>From: {{ $userEmail }}</h2>
<h2>To Music: {{ $musicTitle }}</h2>
<p>{{ $content }}</p>

@endsection
