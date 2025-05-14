
@extends('layouts.email-header')

@section('content')
<h2>From {{ $name }}</h2>
<p>{{ $content }}</p>

@endsection
