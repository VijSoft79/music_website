@extends('adminlte::page')
@section('plugins.BootstrapSwitch', true)

@section('plugins.Summernote', true)

@section('title', 'Dashboard')

@section('content_header')
    <h1>Create Invitation Template</h1>
@stop

@section('content')
    <style>
        .note-editor.note-frame.card {
            width: 100%;
        }
    </style>
    <div class="container-fluid">
        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
        <form class="form-horizontal" method="POST" action="{{ route('curator.offer.template.save') }}">
            <div class="row">
                <div class="col-7" id="standardAlter">

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Invitation Details</h3>
                        </div>

                        @csrf
                        <div class="card-body">
                            <div class="border-bottom row mb-3">
                                <h3 class="card-title">Standard Invitation Form</h3>
                            </div>

                            <x-adminlte-input name="name" label="Invitation Name" type="text" value="{{ old('name') }}" placeholder="My Invitation" />

                            <x-adminlte-input name="invitation_type" label="Invitation type" type="text" value="{{ old('invitation_type') }}" placeholder="Blog, Playlist etc." />

                            <x-adminlte-textarea class="description" name="description" label="Invitation description" placeholder="Enter description...">
                                {{ old('description') }}
                            </x-adminlte-textarea>

                            {{-- is free --}}
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input name="is_free" value="is_free" type="checkbox" class="custom-control-input" id="customSwitc" {{ old('is_free') == 'is_free' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customSwitc">Is your invitation free?</label>
                                </div>
                            </div>

                            <div class="form-group d-none" id="offerPrice">
                                <x-adminlte-input name="offer_price" label="Invitation Price" value="{{ old('offer_price') }}" type="number" placeholder="ex. 20" />
                            </div>

                            <x-adminlte-textarea name="intro" label="Introduction" placeholder="Enter Intro Message">
                                {{ old('intro') }}
                            </x-adminlte-textarea>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input name="add_premium_switch" value="add_premium" type="checkbox" class="custom-control-input" id="customSwitch3" {{ old('add_premium_switch') == 'add_premium' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch3">Secondary Invitation</label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right">
                                        <x-adminlte-button label="learn more" data-toggle="modal" data-target="#modalMin" theme="info" icon="fas fa-info-circle"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="premiumForm" class="d-none">
                            <div class="card-header">
                                <h3 class="card-title">Alternative Invitation Form</h3>

                            </div>
                            <div class="card-body">
                                <x-adminlte-input name="premium_invitation_name" label="Name" type="text" value="{{ old('premium_invitation_name') }}" placeholder="" />
                                <x-adminlte-input name="premium_invitation_type" label="Invitation type" type="text" value="{{ old('premium_invitation_type') }}" placeholder="" />
                                <x-adminlte-textarea class="description" name="premium_invitation_description" label="Invitation description" placeholder="Enter description...">
                                    {{ old('premium_invitation_description') }}
                                </x-adminlte-textarea>
                                <x-adminlte-input name="premium_invitation_price" label="Invitation Price" value="{{ old('premium_invitation_price') }}" type="number" placeholder="ex. 20" />
                                {{-- <x-adminlte-textarea name="premium_invitation_intro" label="Introduction" placeholder="Enter Intro Message">
                                    {{ old('premium_invitation_intro') }}
                                </x-adminlte-textarea> --}}

                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Register Invitation Template</button>
                            <button type="submit" class="btn btn-default float-right">Cancel</button>
                        </div>

                    </div>
                </div>
                
                <div class="col-5" id="freealt">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Free alternatives</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input name="isspotify" value="isspotify" type="checkbox" class="custom-control-input" id="customSwitch4" {{ old('is_spotify') == 'isspotify' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customSwitch4">Is your alternative a Spotify play list?</label>
                                    </div>
                                </div>
                            </div>
                            <div id="spotifyForm">
                                <x-adminlte-input name="playlist_name" label="Playlist Name" type="text" value="{{ old('playlist_name') }}" placeholder="My List" />
                                <x-adminlte-input name="playlist_url" label="Playlist Url" type="text" value="{{ old('playlist_url') }}" placeholder="https://open.spotify.com/playlist/123456/" />
                                <x-adminlte-input name="song_position" label="Song Position" type="number" value="{{ old('song_position') }}" />
                                <x-adminlte-input name="days_of_display" label="Days Of display" type="number" value="{{ old('days_of_display') }}" />
                                <x-adminlte-textarea class="description" name="spotify_description" label="Description" placeholder="Enter Description">
                                    {{ old('spotify_description') }}
                                </x-adminlte-textarea>

                            </div>
                            <div id="normalFomr">
                                <x-adminlte-input name="alternative_name" label="Alternative Type" type="text" value="{{ old('alternative_name') }}" placeholder="My Alternative"/>
                                {{-- <x-adminlte-input name="alternative_description" label="Alternative description" type="text" value="{{ old('alternative_description') }}" placeholder="Enter Description"/> --}}
                                <x-adminlte-input name="alternative_link" label="Alternative Link" type="text" value="{{ old('alternative_link') }}" placeholder="https://sampleLink.com"/>
                                <x-adminlte-textarea class="description " name="alternative_description" label="Description" placeholder="Enter Description">
                                    {{ old('alternative_description') }}
                                </x-adminlte-textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <x-contact-form /> 
                    </div>
                </div>
                
            </div>
        </form>
    </div>

    @php
        $content = App\Models\PageContent::where('title', 'alternative invitation tip')->first();

        // Auth::user()->special->is_special == null ? 0 : Auth::user()->special->is_special;

        // if (Auth::user()->special->is_special === null) {
        //     $isSpecial = 0;
        // } else {
        //     $isSpecial = Auth::user()->special->is_special;
        // }
        
        // $isSpecial = Auth::user()->special->is_special;
    
    @endphp
    @if (!$content == null)
        <x-adminlte-modal id="modalMin" title="Tip">
            {!! $content->content !!}
        </x-adminlte-modal>
    @endif
@stop

@section('js')
    <script>
        //is special input condition
        var UserSpecial = @json($isSpecial);
        console.log(UserSpecial);
        if (UserSpecial == 0 || UserSpecial == '') {
            document.getElementById('freealt').hidden = true;
            document.getElementById('standardAlter').classList.replace('col-7', 'col-12');

            
        }

        $(document).ready(function() {
            //is free
            if ($('#customSwitc').prop('checked')) {
                $('#offerPrice').removeClass('d-block');
                $('#offerPrice').addClass('d-none');
            } else {
                $('#offerPrice').removeClass('d-none');
                $('#offerPrice').addClass('d-block');
            }

            $('#customSwitc').change(function() {
                if ($('#offerPrice').hasClass('d-block')) {
                    $('#offerPrice').removeClass('d-block');
                    $('#offerPrice').addClass('d-none');
                } else {
                    $('#offerPrice').removeClass('d-none');
                    $('#offerPrice').addClass('d-block');
                }
            });

            //has premium
            if ($('#customSwitch3').prop('checked')) {
                $('#premiumForm').removeClass('d-none');
                $('#premiumForm').addClass('d-block');
            } else {
                $('#premiumForm').removeClass('d-block');
                $('#premiumForm').addClass('d-none');
            }

            $('#customSwitch3').change(function() {

                if ($('#premiumForm').hasClass('d-block')) {

                    $('#premiumForm').removeClass('d-block');
                    $('#premiumForm').addClass('d-none');

                } else {

                    $('#premiumForm').removeClass('d-none');
                    $('#premiumForm').addClass('d-block');
                }
            });

            if ($('#customSwitch4').prop('checked')) {
                $('#spotifyForm').removeClass('d-none');
                $('#spotifyForm').addClass('d-block');
                $('#normalFomr').removeClass('d-block');
                $('#normalFomr').addClass('d-none');
            } else {
                $('#spotifyForm').removeClass('d-block');
                $('#spotifyForm').addClass('d-none');
                $('#normalFomr').removeClass('d-none');
                $('#normalFomr').addClass('d-block');
            }

            $('#customSwitch4').change(function() {
                if ($('#spotifyForm').hasClass('d-block')) {

                    $('#spotifyForm').removeClass('d-block');
                    $('#spotifyForm').addClass('d-none');

                    $('#normalFomr').removeClass('d-none');
                    $('#normalFomr').addClass('d-block');


                } else {

                    $('#spotifyForm').removeClass('d-none');
                    $('#spotifyForm').addClass('d-block');

                    $('#normalFomr').removeClass('d-block');
                    $('#normalFomr').addClass('d-none');

                }
            });

            $('.description').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']], // Add the font size option here
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                ],
                height: 500,
                fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48', '64', '82', '150'],
            });


            document.getElementById("learn").onclick = function(e) {
                e.preventDefault();
            };

        });
       
    </script>
@stop
