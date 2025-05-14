@extends('adminlte::master')

@php($dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home'))

@if (config('adminlte.use_route_url', false))
    @php($dashboard_url = $dashboard_url ? route($dashboard_url) : '')
@else
    @php($dashboard_url = $dashboard_url ? url($dashboard_url) : '')
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop



@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
    {{-- <div class="{{ $auth_type ?? 'login' }}-box"> --}}

    {{-- Logo --}}
    {{-- <div class="{{ $auth_type ?? 'login' }}-logo"> --}}
    {{-- <a href="{{ $dashboard_url }}"> --}}

    {{-- Logo Image --}}
    {{-- @if (config('adminlte.auth_logo.enabled', false))
                    <img src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                        alt="{{ config('adminlte.auth_logo.img.alt') }}"
                        @if (config('adminlte.auth_logo.img.class', null)) class="{{ config('adminlte.auth_logo.img.class') }}" @endif
                        @if (config('adminlte.auth_logo.img.width', null)) width="{{ config('adminlte.auth_logo.img.width') }}" @endif
                        @if (config('adminlte.auth_logo.img.height', null)) height="{{ config('adminlte.auth_logo.img.height') }}" @endif>
                @else
                    <img src="{{ asset(config('adminlte.logo_img')) }}" alt="{{ config('adminlte.logo_img_alt') }}"
                        height="50">
                @endif --}}

    {{-- Logo Label --}}
    {{-- {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}  --}}

    {{-- </a> --}}
    {{-- </div> --}}

    {{-- Card Box --}}
    {{-- <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}"> --}}

    {{-- Card Header --}}
    {{-- @hasSection('auth_header')
                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                    <h3 class="card-title float-none text-center">
                        @yield('auth_header')
                    </h3>
                </div>
            @endif --}}

    {{-- Card Body --}}
    {{-- <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                @yield('auth_body')
            </div> --}}

    {{-- Card Footer --}}
    {{-- @hasSection('auth_footer')
                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                    @yield('auth_footer')
                </div>
            @endif --}}

    {{-- </div> --}}

    {{-- </div> --}}


    <div class="container py-5 vh-100 d-flex align-items-center">
        <div class="row d-flex justify-content-center align-items-center h-100 w-100">
            <div class="col-xl-10">
                {{-- Conditionally display heading only on musician register route --}}
                @if(request()->routeIs('musician.register'))
                    <h2 class="fancy-heading">100+ Curators Want to Hear Your Music - Add Your Music Today</h2>
                @endif

                <div class="card text-white overflow-hidden animated-card" style="background-color: #1e293b; border-radius: 15px; box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            {{-- card body --}}
                            <div class="card-body {{ $auth_type ?? 'login' }} {{ config('adminlte.classes_auth_body', '') }} p-md-3 ml-4"
                                style="background-color: #1e293b">
                                <div class="{{ $auth_type ?? 'login' }}-logo">
                                    <a href="{{ $dashboard_url }}">

                                        {{-- Logo Image --}}
                                        @if (config('adminlte.auth_logo.enabled', false))
                                            <img src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                                                alt="{{ config('adminlte.auth_logo.img.alt') }}"
                                                @if (config('adminlte.auth_logo.img.class', null)) class="{{ config('adminlte.auth_logo.img.class') }}" @endif
                                                @if (config('adminlte.auth_logo.img.width', null)) width="{{ config('adminlte.auth_logo.img.width') }}" @endif
                                                @if (config('adminlte.auth_logo.img.height', null)) height="{{ config('adminlte.auth_logo.img.height') }}" @endif>
                                        @else
                                            <img src="{{ asset(config('adminlte.logo_img')) }}"
                                                alt="{{ config('adminlte.logo_img_alt') }}" height="50">
                                        @endif

                                        {{-- Logo Label --}}
                                        {{-- {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}  --}}

                                    </a>
                                </div>

                                @yield('auth_body')
                            </div>

                            {{-- card footer --}}
                            @hasSection('auth_footer')
                                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }} text-center"
                                    style="background-color: #1e293b">
                                    @yield('auth_footer')
                                </div>
                            @endif

                        </div>
                        

                        <div class="col-lg-6">
                            {{-- <svg class="bd-placeholder-img img-fluid rounded-start" width="100%" height="100%" xmlns="{{ asset('/images/login-image/band.png') }}" role="img" ></svg> --}}
                            @if (request()->routeIs('musician.register'))
                                <img src="{{ asset('/images/login-image/register.png') }}" alt="Register Image" class="img-fluid rounded-end h-100 w-100">
                            @else
                                <img src="{{ asset('/images/login-image/login.png') }}" alt="Login Image" class="img-fluid rounded-end h-100 w-100" style="object-fit: cover;">
                            @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    {{-- Yield directive for page-specific content below the card --}}
    @yield('page_specific_content_after_card')

@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.animated-card').addClass('show');
        });
    </script>
@stop
