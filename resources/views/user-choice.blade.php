@extends('layouts.app')

@section('content')
<div class="w-1/2 h-screen mx-auto flex items-center justify-center">
    <a href="{{route('musician.register')}}" class="w-1/2 h-50 flex items-center justify-center h-2/4 rounded mx-2" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('/images/drummer.jpg') }}'); background-repeat: no-repeat; background-size: cover;">
        <h1 class="text-[30px] font-bold">Musician</h1>
    </a>
    <a href="{{route('curator.register')}}" class="w-1/2 h-50 flex items-center justify-center h-2/4 rounded mx-2" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('/images/curator-page-main-image.jpg') }}'); background-repeat: no-repeat; background-size: cover;">
        <h1 class="text-[30px] font-bold">Curator</h1>
    </a>
</div>
@endsection