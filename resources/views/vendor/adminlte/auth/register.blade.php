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

@section('auth_header', __('adminlte::adminlte.register_message'))

@section('auth_body')
    <div class="d-none" id="warning">
        <x-adminlte-alert theme="warning" title="Warning">
            We will be taking artist registrations soon. If you would like to be notified when are ready enter your name, band name, and contact info.
        </x-adminlte-alert>
    </div>
    <form action="{{ $register_url }}" method="post">
        @csrf

        {{-- User type --}}
        <div class="input-group mb-3">

            <label for="user_role">curator</label>
            <input type="radio" name="user_role" value="curator" class="form-control @error('name') is-invalid @enderror"
                checked>

            <label for="user_role">musician</label>
            <input type="radio" name="user_role" value="musician" class="form-control @error('name') is-invalid @enderror">

            @error('user_role')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Name field --}}
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" id="name_field" autofocus>

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
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">

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

            <div class="input-group mb-3">
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
            </div>

            <div class="input-group mb-3">
                <input type="text" name="website" class="form-control @error('website') is-invalid @enderror" placeholder="Enter Website Url">
                @error('website')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>

        {{-- Register button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            {{ __('adminlte::adminlte.register') }}
        </button>

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
    <script>
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
