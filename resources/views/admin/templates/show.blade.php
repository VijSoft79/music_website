@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('admin.templates.partials.free-alternatives-form')
                @include('admin.templates.partials.basic-offer-form')
                @if ($OfferTemplate->has_premium == 1)
                    @include('admin.templates.partials.premium-offer-form')
                @endif

            </div>
        </div>
    </div>
@stop
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
