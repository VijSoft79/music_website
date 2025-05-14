@extends('layouts.email-header')

@section('content')
<h2>From: {{ $email }}</h2>
<p>{{ $content }}</p>

@endsection
