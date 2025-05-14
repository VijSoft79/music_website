@extends('layouts.app')

@section('content')
<div class="hero min-h-screen bg-base-200">
  <div class="hero-content flex-col lg:flex-row">
    <div class="text-center">
        {{-- <div class="flex items-center justify-center h-screen">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-500 ">
                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/>
            </svg>
        </div>   --}}
      <h1 class="text-5xl font-bold mb-5">We'll be right back!</h1>
      <h3 class="text-2xl mb-5">This page is temporarily unavailable, We currently working some updates.</h3>
      <a class="text-blue-500" href="{{ URL::previous() }}">&larr; Get Back</a>
    </div>
  </div>
</div>
@endsection