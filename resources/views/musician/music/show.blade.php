{{-- Extend the adminlte layout --}}
@extends('adminlte::page')

{{-- Set the title of the page --}}
@section('title', 'Music')

@section('plugins.TempusDominusBs4', true)
@section('plugins.BootstrapSwitch', true)

{{-- Define the content for the content_header section --}}
@section('content_header')
    <div class="container">
        <h1 class="font-weight-bold">{{ $music->title }}</h1>
    </div>
@stop

{{-- Define the main content of the page --}}
@section('content')
    <div class="container pb-3">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class="w-100 mx-auto" style="display: inline; justify-content: center; align-items: center;">
                            {!! $music->embeded_url !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Music Details
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl>
                                    <dt>Release Date</dt>
                                    <dd>{{ $music->release_date }}</dd>

                                    <dt>Genre</dt>
                                    <dd>
                                        @foreach ($music->genres as $genre)
                                            {{ $genre->name }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl>
                                    <dt>Release Type</dt>
                                    <dd>{{ $music->release_type }}</dd>

                                    <dt>Song Version</dt>
                                    <dd>{{ $music->song_version }}</dd>
                                </dl>
                            </div>
                        </div>
                        <dl>
                            <dt>Offer Stats</dt>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td class="col-6">Invitation Received</td>
                                        {{-- Replace this placeholder with the actual count --}}
                                        {{-- <td class="col-6">{{ $music->offer->count() ?: 0 }}</td> --}}
                                    </tr>
                                </tbody>
                            </table>

                            <dt>Description</dt>
                            <dd>{!! $music->description !!}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <a class="w-100 d-block" href="{{ asset($music->image_url) }}" download style="width: 300px; height: 300px;">
                    <img src="{{ asset($music->image_url) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                </a>
            </div>
        </div>
        {{-- press release --}}

        <livewire:musician.music.press-release :music="$music" /> 

        {{-- additional images --}}
        <h3>Other Images</h3>       
        @if ($music->images()->count())
            <p>Note: click the image to download</p>
            <div class="row">
                @foreach ($music->images() as $image)
                <div class="col-md-3 mb-3">
                    <a href="{{ asset('storage/'.$image->image_path) }}" download>
                        <img class="w-100" src="{{ asset('storage/'.$image->image_path) }}" alt="music image">
                    </a>
                </div>
                @endforeach
                
            </div>
        @else
            <div class="text-center mb-4">
                <p class="mb-3">No additional images yet</p>
                <button type="button" class="btn btn-primary" id="addImagesButton">
                    <i class="fas fa-plus-circle"></i> Add Images
                </button>
            </div>

            {{-- Add Images Modal --}}
            <div class="modal fade" id="addImagesModal" tabindex="-1" aria-labelledby="addImagesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('musician.music.add-images', $music->id) }}" method="POST" enctype="multipart/form-data" id="imageUploadForm">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="addImagesModalLabel">Add Images</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="images" class="form-label">Select Images</label>
                                    <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/jpeg,png,jpg,gif" required onchange="validateFiles(this)">
                                    <div class="form-text">
                                        Upload one or more images (JPEG, PNG, JPG, GIF)<br>
                                        Maximum size: 3MB per image<br>
                                        Maximum number of images: 4<br>
                                        Minimum dimensions: 300x300 pixels
                                    </div>
                                    <div id="imagePreview" class="mt-3"></div>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Upload Images</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop

{{-- Include any JavaScript specific to this page --}}
@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            // Ensure any iframe is set to 100% width
            $('iframe').css('width', '100%');

            // Initialize Bootstrap modal
            const addImagesModal = new bootstrap.Modal(document.getElementById('addImagesModal'));
            
            // Show modal if there are any validation errors
            @if($errors->any())
                addImagesModal.show();
            @endif

            // Add click handler for the button
            $('#addImagesButton').on('click', function() {
                addImagesModal.show();
            });
        });

        function validateFiles(input) {
            const maxFiles = 4;
            const maxSize = 3 * 1024 * 1024; // 3MB in bytes
            const preview = $('#imagePreview');
            preview.empty();

            if (input.files.length > maxFiles) {
                alert(`You can only upload up to ${maxFiles} images at once.`);
                input.value = '';
                return;
            }

            let validFiles = true;
            Array.from(input.files).forEach(file => {
                if (file.size > maxSize) {
                    alert(`File "${file.name}" exceeds 3MB. Please choose a smaller file.`);
                    validFiles = false;
                }
            });

            if (!validFiles) {
                input.value = '';
                return;
            }

            // Show preview of valid files
            if (input.files) {
                preview.append('<div class="row">');
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.append(`
                            <div class="col-md-4 mb-2">
                                <img src="${e.target.result}" class="img-fluid" alt="Preview">
                            </div>
                        `);
                    }
                    reader.readAsDataURL(file);
                });
                preview.append('</div>');
            }
        }
    </script>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .image-preview {
            max-width: 100%;
            margin-top: 10px;
        }
        #imagePreview img {
            max-height: 150px;
            object-fit: cover;
        }
        .modal-dialog {
            max-width: 600px;
        }
    </style>
@stop
