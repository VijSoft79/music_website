{{-- Extend the adminlte layout --}}
@extends('adminlte::page')

{{-- Include the BsCustomFileInput plugin for file inputs --}}
@section('plugins.BsCustomFileInput', true)

@section('plugins.TempusDominusBs4', true)

{{-- Set the title of the page --}}
@section('title', 'Dashboard')

{{-- Define the content for the content_header section --}}
@section('content_header')
    <div class="container">
        <h1>{{ $template->basicOffer->name }}: Invitation to {{ $music->title }}</h1>
    </div>
@stop

{{-- Define the main content of the page --}}
@section('css')
    <style>
        iframe {
            width: 100%;
            height: 300px;
        }

        .profile-image {
            width: 100%;
            height: auto;
        }

        .profile-widget {
            background: #343a40;
            color: #fff;
        }

        .profile-widget .card-header {
            background: linear-gradient(135deg, #6e7dff, #00c6ff);
        }

        .profile-widget .card-footer {
            background: #1f2c47;
        }

        .custom-modal .modal-header {
            background: linear-gradient(135deg, #6e7dff, #00c6ff);
            color: #fff;
        }

        .custom-modal .modal-body {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
@endsection

@section('content')

    <div class="container pb-5">
        <div class="row">
            {{-- Display success message if any --}}
            @if (session('message'))
                <div class="col-12">
                    <x-adminlte-alert theme="success" title="Success">
                        {{ session('message') }}
                    </x-adminlte-alert>
                </div>
            @endif

            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class="w-100 mx-auto" style="display: flex; justify-content: center; align-items: center;">
                            {!! $music->embeded_url !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Music details and embedded content --}}
            <div class="col-md-6">
                @include('curator.offers.partials.music-details')
                @include('curator.offers.partials.offer-status')
            </div>

            {{-- Include chat component --}}
            <div class="col-md-6" id="chat-box-wrapper">
                {{-- @include('chats.chats') --}}
                @if ($offer)
                    <livewire:chat-box :offer="$offer" />
                @endif
                
            </div>
            {{-- music images --}}
            @include('curator.offers.partials.music-images')

            {{-- Preview PDF --}}
            @include('curator.offers.partials.press-release')

            {{-- Invitation info and action --}}
            <div class="col-12 mt-4">
                <div class="card card-primary card-outline direct-chat direct-chat-primary shadow-none">
                    <div class="card-header">
                        <h3 class="mb-0">Invitation Info:</h3>
                    </div>

                    {{-- Offer status check --}}
                    @if ($offer->status == 0)
                        {{-- Include offer type list --}}
                        @include('curator.offers.partials.offer-type-list')
                    @else
                        {{-- Include chosen offer type --}}
                        @include('curator.offers.partials.chosen-offer')
                    @endif

                    {{-- Button to submit completed work if offer status is 1 --}}
                    @if ($offer->status == 1)
                        <div class="card-footer">
                            <x-adminlte-button label="Submit Completed Work" data-toggle="modal" data-target="#completionForm" class="bg-teal" />
                        </div>
                    @endif
                </div>
            </div>

            @if ($offer->report)
                @include('curator.offers.partials.reports')
            @endif
            
        </div>
    </div>

    {{-- Modal for completion report form --}}
    <div class="modal fade custom-modal" id="completionForm" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" v-centered static-backdrop scrollable>
        <div class="modal-dialog modal-lg">
            <form action="{{ route('curator.offers.check', $offer) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="myModalLabel"><i class="fa-solid fa-bell ml-1 mr-2"></i> Completion Report Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">

                        {{-- Sample link input --}}
                        <x-adminlte-input label="Sample Link" name="sample_link[]" type="text" placeholder="https://www.example.com/sample" />

                        {{-- Container for additional link inputs --}}
                        <div id="additionalLinks"></div>

                        {{-- Button to add another link --}}
                        <x-adminlte-button type="button" theme="info" label="Add Another Link" id="addLinkBtn" class="mb-4"/>

                        {{-- File input for uploading images --}}
                        <x-adminlte-input-file id="ifMultiple" name="checkImages[]" label="Upload Images of Proven Work" placeholder="Choose multiple files..." igroup-size="lg" legend="Choose" multiple>
                            <x-slot name="prependSlot">
                                <div class="input-group-text text-primary">
                                    <i class="fas fa-file-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>

                        {{-- Preview container for uploaded images --}}
                        <div id="imagePreviewContainer" class="mt-3 d-flex flex-wrap"></div>

                        {{-- Loading indicator --}}
                        <div id="loadingIndicator" class="mt-3 text-center d-none">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                            <p>Uploading...</p>
                        </div>

                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="modal fade" id="modalMin" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Select Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    
                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="{{ route('curator.change.date') }}" method="POST" id="changeDate">
                        @csrf
                        @php
                            $config = ['format' => 'L'];
                        @endphp
                        <x-adminlte-input-date id="idDateOnly" name="date" :config="$config" 
                            value="{{ old('date', $offer->date_complete) }}" placeholder="Choose a date...">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-gradient-success">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                        <input type="hidden" name="offer" value="{{ $offer->id }}">
                    
                        <!-- Modal Footer (Submit Inside Form) -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('ifMultiple').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('imagePreviewContainer');
            const loadingIndicator = document.getElementById('loadingIndicator');

            previewContainer.innerHTML = ''; // Clear previous previews
            loadingIndicator.classList.remove('d-none'); // Show loading indicator

            // Simulate a fake upload delay (e.g., 2 seconds)
            setTimeout(() => {
                loadingIndicator.classList.add('d-none'); // Hide loading indicator

                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxWidth = '150px'; // Adjust the size as needed
                            img.style.margin = '5px';
                            previewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }, 2000); // 2 seconds delay
        });

        document.getElementById('addLinkBtn').addEventListener('click', function() {
            // Create a new input group for the additional link
            let newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-3');

            newInputGroup.innerHTML = `
            <input type="text" name="sample_link[]" class="form-control" placeholder="https://www.example.com/sample" />
            <div class="input-group-append">
                <button class="btn btn-danger remove-link" type="button">Remove</button>
            </div>
        `;

            // Append the new input group to the additional links container
            document.getElementById('additionalLinks').appendChild(newInputGroup);
        });

        // Add event listener for dynamically added "Remove" buttons
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-link')) {
                // Remove the corresponding input group
                event.target.closest('.input-group').remove();
            }
        });
    </script>

@stop

{{-- Include any JavaScript specific to this page --}}
@section('js')
    <script></script>
@stop
