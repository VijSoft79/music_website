@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.BsCustomFileInput', true)

@section('content_header')
    <h1>{{ ucfirst(Auth::user()->name) }}</h1>
@stop

@section('css')
    <style>
        .main-footer {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            /* background-color: #f8f9fa; */
            text-align: center;
            padding: 1rem;
        }
    </style>
@stop

@section('content')
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @elseif(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-12">
                @include('partials.email-preferences-form')
            </div>
        </div>

        <form class="w-100 py-5" action="{{ route('curator.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-12 col-md-3">
                    @include('curator.partials.profile-image-form')
                </div>
                <div class="col-12 col-md-9">
                    @include('curator.partials.profile-about-me-form')
                </div>
                @if (Auth::user()->hasRole('curator'))
                    <div class="col-12">
                        @include('curator.partials.curator-socials')
                    </div>

                    <div class="col-12">
                        @include('curator.partials.additional-information-form')
                    </div>
                @endif
            </div>
            <div class="col-12 mb-5">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        var loadFile = function(event) {
            var fileInput = event.target;
            var file = fileInput.files[0];

            var reader = new FileReader();

            reader.onloadstart = function() {
                document.querySelector('.progress').style.display = 'block';
            };

            reader.onprogress = function(e) {
                if (e.lengthComputable) {
                    var percentComplete = (e.loaded / e.total) * 100;
                    document.getElementById('progressBar').style.width = percentComplete + '%';
                    document.getElementById('progressBar').innerHTML = percentComplete.toFixed(2) + '%';
                }
            };

            reader.onload = function() {
                var imgSrc = reader.result;
                document.getElementById('profileImage').src = imgSrc;
                document.querySelector('.progress').style.display = 'none';
            };

            reader.readAsDataURL(file);
        };
    </script>
@stop
