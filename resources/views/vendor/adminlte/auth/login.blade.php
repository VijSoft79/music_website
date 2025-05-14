@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))
@php($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
    @php($password_reset_url = $password_reset_url ? route($password_reset_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
    @php($password_reset_url = $password_reset_url ? url($password_reset_url) : '')
@endif

@section('auth_header', __('adminlte::adminlte.login_message'))

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


@section('auth_body')

    <form action="{{ route('curator.login.save') }}" method="post">
        @csrf

        {{-- Email field --}}
        <div class="input-group mb-4 mt-5">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>

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

        {{-- Login field --}}
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary" title="{{ __('adminlte::adminlte.remember_me_hint') }}">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        {{ __('adminlte::adminlte.remember_me') }}
                    </label>
                </div>
            </div>

            @if ($password_reset_url)
                <p class="ml-4">
                    <a href="{{ $password_reset_url }}">
                        {{ __('adminlte::adminlte.i_forgot_my_password') }}
                    </a>
                </p>
            @endif
        </div>

        {{-- <div class="g-recaptcha" data-sitekey="6LeNitsqAAAAADlYEUAe13urbfgaLP5Ic3fmCijE"></div> --}}


        <div>
            <button type=submit class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }} mt-5 ">
                <span class="fas fa-sign-in-alt"></span>
                {{ __('adminlte::adminlte.sign_in') }}
            </button>
        </div>


    </form>

@stop

@section('auth_footer')
    {{-- Password reset link --}}
    {{-- @if ($password_reset_url)
        <p class="my-0">
            <a href="{{ $password_reset_url }}">
                {{ __('adminlte::adminlte.i_forgot_my_password') }}
            </a>
        </p>
    @endif --}}

    {{-- Register link --}}
    @if ($register_url)
        <p class="mt-3">
            <a href="/choose">
                {{ __('adminlte::adminlte.register_a_new_membership') }}
            </a>
        </p>
    @endif
    {{-- <div class="d-flex align-items-center mt-5">
        <hr class="flex-grow-1" style="border-top: 1px solid white;">
        <span class="mx-2">Sign-In Using</span>
        <hr class="flex-grow-1" style="border-top: 1px solid white;">
    </div>


    <div class="row my-3 d-flex justify-content-center">
        <div class="col-6 text-center">
            <a href="#" type="submit" class="btn btn-primary"><i class="fa-brands fa-facebook-f"></i> acebook</a>
        </div>
        <div class="col-6 text-center">
            <a href="{{ route('user.type.choose') }}" class="btn btn-danger"><i class="fa-brands fa-google"></i>oogle</a>
        </div>
    </div> --}}
@stop

@section('js')

{{-- 
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
                action: 'login'
            }).then(function(token) {
                document.getElementById('recaptcha-response').value = token;
            });
        });
    </script> --}}
@stop
