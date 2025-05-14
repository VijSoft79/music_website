@extends('adminlte::page')

@section('title', 'Invitation Templates')

@section('content_header')
    <h1>Invitation Templates</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if ($OfferTemplate) 
                    @if ($OfferTemplate->freeAlternative)
                        @include('curator.offer-templates.partials.free-alternatives-form')
                    @elseif ($OfferTemplate->spotifyPlayList)
                        @include('curator.offer-templates.partials.spotify-playlist-form')
                    @endif

                    @include('curator.offer-templates.partials.basic-offer-form')

                    @if ($OfferTemplate->has_premium == 1)
                        @include('curator.offer-templates.partials.premium-offer-form')
                    @endif
                @endif
            </div>
        </div>
    </div>
    </div>
@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var inputs = document.querySelectorAll('.input');
            inputs.forEach(function(input) {
                input.disabled = true;
            });
        });
    </script>
@stop
@stop
