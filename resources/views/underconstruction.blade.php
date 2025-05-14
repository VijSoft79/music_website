@extends('layouts.app')

@section('content')
<div class="hero min-h-screen bg-base-200">
    <div class="hero-content flex-col lg:flex-row">
      <div class="text-center">
        <h1 class="text-5xl font-bold mb-10">This Feature is Coming Soon</h1>
        <a class="text-blue-500" href="{{ URL::previous() }}">&larr; Get Back</a>
      </div>
    </div>
  </div>
@endsection