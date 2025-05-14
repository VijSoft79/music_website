@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="pl-2">{{ Auth::user()->name }} Profile</h1>
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

    <div class="container-fluid py-3">
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

        <div class="d-flex justify-content-end">
            <x-contact-form />
        </div>

        <div class="row mb-4">
            <div class="col-12">
                @include('partials.email-preferences-form')
            </div>
        </div>

        <form action="{{ route('musician.update') }}" method="post" enctype="multipart/form-data" class="w-100 mb-5">
            @csrf
            <div class="row">
                <input name="id" type="hidden" value="{{ Auth::user()->id }}">

                <div class="col-md-3">
                    @include('musician.partials.profile-image-form')
                </div>

                <div class="col-md-9">
                    <div class="card w-100">
                        <div class="card-body">
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="inputPassword" class="col-sm-3 col-form-label">Contact Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="name"
                                                value="{{ old('name', Auth::user()->name) }}" class="form-control"
                                                id="inputPassword">
                                        </div>
                                    </div>
                                </div>

                                <!-- Band Name -->
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Band Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="band_name"
                                                value="{{ old('band_name', Auth::user()->band_name) }}" class="form-control"
                                                id="inputPassword">
                                        </div>
                                    </div>
                                </div>

                                <!-- email -->
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="email"
                                                value="{{ old('email', Auth::user()->email) }}" class="form-control"
                                                id="inputPassword">
                                        </div>
                                    </div>
                                </div>

                                <!-- Genre -->
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Genre</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="genre"
                                                value="{{ old('genre', Auth::user()->genre) }}" class="form-control"
                                                id="inputPassword">
                                        </div>
                                    </div>
                                </div>

                                <!-- location -->
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Location</label>
                                        <div class="col-sm-10">
                                            <x-adminlte-select name="location" fgroup-class="">

                                                <option value="{{ old('location', Auth::user()->location) }}" selected>
                                                    {{ old('location', Auth::user()->location) }}</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country['name'] }}"
                                                        data-capital="{{ $country['calling_code'] }}">
                                                        {{ $country['name'] }}</option>
                                                @endforeach

                                            </x-adminlte-select>

                                        </div>

                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="mb-3 row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Band Bio</label>
                                        <div class="col-sm-12">
                                            <textarea name="bio" rows="4" class="form-control">{{ old('bio', Auth::user()->bio) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-12">
                    @include('musician.partials.musician-socials')
                </div>

                {{-- <div class="col-12">
                    @include('musician.partials.additional-information-form')
                </div> --}}

            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary mb-5">Save</button>
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
