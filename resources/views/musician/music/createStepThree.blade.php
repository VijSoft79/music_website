@extends('adminlte::page')
@section('title', 'music')

@section('content_header')
    <div class="container">
        <h1>Submit Music - step three for "{{ $music['title'] }}"</h1>
    </div>

@stop

@section('content')
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

    @endif
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('musician.create.step.three.post') }}" method="post">
            @csrf
            <div class="form-group">
                @foreach ($genres as $genre)
                    <div class="row py-3">
                        <div class="col-12 p-0">
                            <h5>
                                <div class="form-check">
                                    <input id="genre-{{ $genre->id }}" name="genre[]" value="{{ $genre->id }}" class="form-check-input parent-genre" type="checkbox">
                                    <label class="form-check-label fw-bold text-capitalize" style="font-weight: 700">{{ $genre->name }}</label>
                                </div>
                            </h5>
                            @if ($genre->childGenres->count() > 0)
                                <div class="row w-100 ml-4">
                                    @foreach ($genre->childGenres as $childGenre)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input id="genre-{{ $childGenre->id }}" name="genre[]" value="{{ $childGenre->id }}" class="form-check-input child-genre" type="checkbox" data-parent-id="{{ $genre->id }}">
                                                <label class="form-check-label">{{ $childGenre->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Next</button>
        </form>
        <div class="row justify-content-end">
            <x-contact-form />  
        </div>
    </div>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const childGenreCheckboxes = document.querySelectorAll('.child-genre');

            childGenreCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const parentId = this.getAttribute('data-parent-id');
                    const parentCheckbox = document.getElementById('genre-' + parentId);

                    if (this.checked) {
                        parentCheckbox.checked = true;
                    }
                });
            });
        });
    </script>
@stop
