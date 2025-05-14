@extends('adminlte::page')

@section('title', 'Dashboard')
@section('plugins.Summernote', true)
@section('content_header')
    <h1>Edit Offer-Templates</h1>
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

        <div class="row">
            <div class="col-12">
                <form action="{{ route('curator.offer.template.update', $OfferTemplate) }}" method="post" class="py-3">
                    @csrf

                    @if ($OfferTemplate->freeAlternative)
                        @include('curator.offer-templates.partials.free-alternatives-form')
                    @elseif($OfferTemplate->spotifyPlayList)
                        @include('curator.offer-templates.partials.spotify-playlist-form')
                    @else
                    
                    @endif

                    @include('curator.offer-templates.partials.basic-offer-form')

                    @if ($OfferTemplate->has_premium == 1)
                        @include('curator.offer-templates.partials.premium-offer-form')
                    @endif

                    <div class="col-2">
                        <button type="submit" class="btn btn-block btn-outline-primary">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.description').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                ],
                height: 500,
                fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48', '64', '82', '150'],

            });
        });
    </script>
@stop
