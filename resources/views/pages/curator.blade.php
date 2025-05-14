@extends('layouts.app')
@section('title')
    - Curator
@endsection

@section('content')
    <div class="md:w-3/4 md:mx-auto p-5">
        <div class="md:flex p-1 gap-6 mx-auto ">
            <div class="basis-2/6 rounded-l-lg" style="">
                <img src="{{ asset('/images/curator-page-main-image.jpg') }}" class="w-full rounded-lg shadow-2xl" />
                <a href="{{ route('curator.register') }}" class="btn btn-primary my-3 font-bold text-white ">Register As A Curator</a>
            </div>

            <div class="basis-4/6 rounded-r-lg">
                <h1 class="text-2xl md:text-5xl font-bold">For Curators</h1>
                {!! '<article class="py-6">' . $pageContent->content . '</article>' !!}
            </div>
        </div>

    </div>
@endsection
