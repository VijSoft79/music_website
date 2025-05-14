@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.BsCustomFileInput', true)
@section('plugins.BootstrapSwitch', true)

@section('plugins.TempusDominusBs4', true)

@section('content_header')
    <h1>Admin Dashboard</h1>
@stop

@section('content')
    <div class="container-fluid">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
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

        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img id="musicPreview" class="img-fluid" src="{{ asset($music->image_url) }}" alt="Music Image">
                        </div>
                        <h3 class="profile-username text-center">{{ $music->title }}</h3>
                        <div style="display:flex">
                            @php
                                $isYouTube = false;
                                if (strpos($music->embeded_url, 'youtube.com') !== false || strpos($music->embeded_url, 'youtu.be') !== false) {
                                    $isYouTube = true;
                                }
                            @endphp

                            @if (!$isYouTube)
                                {!! $music->embeded_url !!}
                            @endif

                        </div>
                        <form action="{{ route('admin.music.update.image', $music) }}" enctype="multipart/form-data" method="post">
                            @csrf

                            <div class="custom-file col-12 mt-1 mb-5">
                                <label for="musicImage">Upload Image</label>
                                <p class="text-danger m-0">Allowed files: .jpeg, .jpg, .png or .gif</p>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="musicImage" name="musicImage" accept=".jpeg,.jpg,.png" onchange="previewImage(event)">
                                    <label class="custom-file-label" for="musicImage">Upload File</label>
                                </div>
                                <button type="submit" class="btn btn-primary mt-1" id="uploadImage" hidden>Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-title">
                                    Music Details
                                </h3>
                            </div>
                            <div class="col-6 text-right">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" {{ $music->status == 'approve' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customSwitch1">Is Approve</label>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                    <div class="card-body">
                        @if ($isYouTube)
                            <div class="d-flex justify-content-center align-items-center my-3 ">
                                {!! $music->embeded_url !!}
                            </div>
                        @endif
                        <dl>
                            <dt>Artist</dt>
                            <dd>{{ $music->artist->name }}</dd>

                            <dt>Genre</dt>
                            <dd>
                                @foreach ($music->genres as $genre)
                                    {{ $genre->name }},
                                @endforeach
                            </dd>

                            <dt>Release Type</dt>
                            <dd>{{ $music->release_type }}</dd>

                            <dt>Song version</dt>
                            <dd>{{ $music->song_version }}</dd>

                            <dt>description</dt>
                            <dd>{!! $music->description !!}</dd>

                            @if ($music->status === 'pending')
                                <div class="col-5">
                                    <form action="{{ route('admin.music.update', $music->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-block btn-success btn-lg">Approve
                                            Music</button>
                                    </form>
                                </div>
                            @endif


                        </dl>
                    </div>
                </div>

                <livewire:musician.music.press-release :music="$music" />
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).on('change', '#customSwitch1', function() {
            let musicid = '{{ $music->id }}'; // Retrieve the music ID from the template
            let approve = false;

            if ($(this).is(':checked')) {
                approve = 1; // Set approve to 1 (true) if the switch is checked
            } else {
                approve = 0; // Set approve to 0 (false) if the switch is not checked
            }

            $.ajax({
                url: "{{ route('admin.music.approve') }}", // URL to send the AJAX request to
                type: 'post', // HTTP method
                data: {
                    _token: $('input[name="_token"]').val(), // CSRF token for security
                    music_id: musicid, // ID of the music track to update
                    approve: approve // Approval status to set
                },
                success: function(response) {
                    confirm(response.message);
                },
                error: function(error) {
                    console.log(error.responseJSON); // Log error response
                }
            });
        });

        //for image preview
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('musicPreview');
                preview.src = reader.result;
                document.getElementById("uploadImage").hidden = false;

            };

            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

@stop
