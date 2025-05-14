@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ Auth::user()->name }}</h1>
@stop

@section('content')
    @if (session('message') && session('message') != null)
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <x-adminlte-card id="successMessage{{ session('musicId') }}" theme="warning" theme-mode="outline">
                        {{ session('message') }}
                    </x-adminlte-card>
                </div>
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- user status message --}}
    @if (!Auth::user()->music->count())
        @include('musician.partials.status-message')
    @endif

    {{-- music status --}}
    @include('musician.partials.music-status')

    {{-- offer list --}}
    @include('musician.partials.offer-list')

    <h3 class="mb-2"><b>How to</b></h3>
    <div class="row justify-content-center">

        <!-- Step 1 -->
        <div class="col-md-6 d-flex justify-content-center mb-5 flex-column align-items-center">
            <p class="h5 mb-3"><b>"Musicians Step 01 // Registration and Profile"</b></p>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/nfQpAhi17to?si=y3IECpK9ZxVbpj7j" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

        <!-- Step 2 -->
        <div class="col-md-6 d-flex justify-content-center mb-5 flex-column align-items-center">
            <p class="h5 mb-3"><b>"Musicians Step 02 // Submitting a Song"</b></p>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/YCziKpRVp-w?si=wUS-fyH_E4FEEnEe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

        <!-- Step 3 -->
        <div class="col-md-6 d-flex justify-content-center mb-5 flex-column align-items-center mb-5">
            <p class="h5 mb-3"><b>"Musicians Step 03 // Accepting Invitations"</b></p>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/3S9j8eAByIE?si=FwZN1KvtqCUULvd_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

        <!-- Step 4 -->
        <div class="col-md-6 d-flex justify-content-center mb-5 flex-column align-items-center mb-5">
            <p class="h5 mb-3"><b>"Musicians Step 04 // Viewing Completed Promotions"</b></p>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/bnjEk1k7caQ?si=XtI0QgIhnSH7zxfv" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>


@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let sucmes = $('#successMessage{{ session('musicId') }}').is(':visible');
            let permes = $('#permanentMessage{{ session('musicId') }}');

            console.log('Success message visibility:', sucmes);
            console.log('Permanent message element:', permes);

            if (sucmes) {
                permes.hide();
                console.log('Success message is visible, hiding permanent message.');
            } else {
                permes.show();
                console.log('Success message is not visible, showing permanent message.');
            }
        });
    </script>
@stop
