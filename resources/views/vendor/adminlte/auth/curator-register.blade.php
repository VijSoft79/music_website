@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
@endif

@push('css')
    <style>
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animated-card {
            animation: slideDown 0.5s ease forwards;
            opacity: 0;
            /* Start with invisible */
        }


        .animated-card.show {
            animation: slideDown 0.5s ease forwards;
        }
    </style>
@endpush


@section('auth_header', 'register as a curator')

@section('auth_body')
    @if ($errors->has('$attribute'))
        <div class="alert alert-danger">
            {{ $errors->first('$attribute') }}
        </div>
    @endif
    <form action="{{ route('curator.register.save') }}" method="post" id="registerForm">

        @csrf
        <input name="user_role" type="hidden" value="curator">

        {{-- Name field --}}
        <div class="input-group mt-4 mb-3">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Publication" id="name_field" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('adminlte::adminlte.password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Confirm password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('adminlte::adminlte.retype_password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-block" id="curator-field">

            {{-- <div class="input-group mb-3">
                <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" placeholder="Phone Number"   data-toggle="tooltip" data-placement="top" title="Enter Your Phone Number and We Will Send you a Text Message When The Website is Fully Operational">

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fa fa-question-circle"></span>
                    </div>
                </div>
                @error('contact')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> --}}

            {{-- <div class="input-group mb-3">
                <input type="text" name="website" class="form-control @error('website') is-invalid @enderror" placeholder="Enter Website Url">
                @error('website')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> --}}

        </div>
        {{-- <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }} " data-action='register'></div> --}}
        <input type="hidden" name="page-token" value="<?php echo strtoupper(substr(bin2hex(random_bytes(4)), 0, 8)); ?>">

        <div class="g-recaptcha" data-sitekey="6LewNd0qAAAAAJ5lDOcIvkzzd0Y33ynlFTD4rlVC"></div>

        {{-- Register button --}}
        <button class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }} mt-5">
            {{ __('adminlte::adminlte.register') }}
        </button>
        {{-- <div class="d-flex align-items-center my-5">
            <hr class="flex-grow-1" style="border-top: 1px solid white;">
            <span class="mx-2">Sign-Up Using</span>
            <hr class="flex-grow-1" style="border-top: 1px solid white;">
        </div> --}}

        {{-- <div class="row my-3 d-flex justify-content-center">
            <div class="col-6 text-center">
                <a href="#" type="submit" class="btn btn-primary"><i class="fa-brands fa-facebook-f"></i> acebook</a>
            </div>
            <div class="col-6 text-center">
                <a href="{{route('auth.google')}}" name="role" value="curator" class="btn btn-danger"><i class="fa-brands fa-google"></i>oogle</a>
            </div>
        </div> --}}

    </form>

@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@stop

@section('js')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    <script>
        function onSubmit(token) {
            document.getElementById("registerForm").submit();
        }

        $(document).ready(function() {
            let radio = $('input[name="user_role"]');
            let cont = $('#name_field');


            cont.attr("placeholder", "Publication");
            radio.change(function() {

                let selectedValue = $('input[name="user_role"]:checked').val();
                let field = $('#curator-field');
                let warn = $('#warning');

                if (selectedValue == "curator") {
                    field.removeClass('d-none');
                    field.addClass('d-block');

                    warn.addClass('d-none');
                    warn.removeClass('d-block');

                    cont.attr("placeholder", "Publication");
                } else {
                    field.removeClass('d-block');
                    field.addClass('d-none');

                    warn.removeClass('d-none');
                    warn.addClass('d-block');


                    field.val('');
                    cont.attr("placeholder", "Name");

                }
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
