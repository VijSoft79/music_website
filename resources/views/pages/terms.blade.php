@extends('layouts.app')

@section('title')
    - Terms And Condition
@endsection

@section('content')
    <div class="md:w-3/4 md:mx-auto p-5">
    <h1 class="font-bold text-3xl mb-5">Terms & Condition</h1>
    {!! $pageContent->content !!}
    </div>
@endsection
