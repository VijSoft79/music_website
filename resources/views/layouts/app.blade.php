<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="71UEzEovmRhjJ8tIcJ-j570u5Z88fRcwfd8ZsIEpDh0" />
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'youhearus') }}</title> --}}
    <title>{{ config('app.name', 'youhearus') }} @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    @vite('resources/css/app.css')
    @yield('head')
    {{-- <style>
        #end {
            min-width: 390px;
        }
        html,body {
            /* width: 100%; */
            max-width: 100%;
            min-width: fit-content;
        }
       
    </style> --}}

    {{-- captcha --}}
    {{-- <script src="https://www.google.com/recaptcha/api.js"></script> --}}

    {{-- <script src="https://www.google.com/recaptcha/enterprise.js?render=6LeNitsqAAAAADlYEUAe13urbfgaLP5Ic3fmCijE"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9RF6T26V5V"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-9RF6T26V5V');
    </script>

    <!-- Meta Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1558375448883471');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1558375448883471&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
</head>

<body>

    <div id="app" class="min-h-screen flex flex-col">
        <div class="navbar bg-base-100 sticky top-0 z-10">
            <div class="navbar-start" id="start">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('page.curator', 'curator') }}">Curator</a></li>
                        <li><a href="{{ route('page.curator', 'musician') }}">Musician</a></li>
                        <li><a href="{{ route('page.blog.index') }}">Blog</a></li>
                        <li><a href="{{ route('page.contact') }}">Contact</a></li>
                        <li><a href="{{ route('page.faqs') }}">FAQ's</a></li>
                    </ul>
                </div>
                <a href="/" class="btn btn-ghost">
                    <img class="w-1/2 md:w-full" src="{{ asset('/images/logo.png') }}" alt="">
                </a>
            </div>

            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="{{ route('page.curator', 'curator') }}">Curator</a></li>
                    <li><a href="{{ route('page.curator', 'musician') }}">Musician</a></li>
                    <li><a href="{{ route('page.blog.index') }}">Blog</a></li>
                    <li><a href="{{ route('page.contact') }}">Contact</a></li>
                    <li><a href="{{ route('page.faqs') }}">FAQ's</a></li>
                </ul>
            </div>

            <div class="navbar-end flex-col md:flex-row justify-end" id="end">
                @guest
                    @if (Route::has('login'))
                        <a class="px-2 sm:left-auto" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @endif
                @else
                    <a class="btn btn-ghost" href="/dashboard/@if(Auth::user()->getRoleNames()[0] != 'administrator'){{ Auth::user()->getRoleNames()[0] }} @endif"role="button">
                        {{Auth::user()->name}}</a>

                    <form id="logout-form" action="{{ url(config('adminlte.logout_url')) }}" method="POST" class="d-none">
                        @csrf
                        <button class="btn btn-ghost" type="submit">{{ __('Logout') }}</button>
                    </form>                
		@endguest
            </div>
        </div>
        <main class="flex-grow">
            @yield('content')
        </main>
        <footer class="footer footer-center p-10 bg-base-200 text-base-content rounded mt-auto">
            <nav class="grid grid-flow-col gap-4">
                <a href="{{ route('page.aboutus') }}" class="link link-hover">About us</a>
                <a href="{{ route('page.contact') }}" class="link link-hover">Contact</a>
                <a href="{{ route('page.curator', 'terms') }}" class="link link-hover">Terms & Conditions</a>
            </nav>
            <nav>
                <div class="grid grid-flow-col gap-4">
                    <a rel="nofollow" href="https://www.instagram.com/youhearus/"><svg width="24" height="24" viewBox="0 0 32 32" id="Camada_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#1f2937" stroke="#1f2937">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <style type="text/css">
                                    .st0 {
                                        fill: #FFFFFF;
                                    }
                                </style>
                                <path d="M6,2h20c2.2,0,4,1.8,4,4v20c0,2.2-1.8,4-4,4H6c-2.2,0-4-1.8-4-4V6C2,3.8,3.8,2,6,2z">
                                </path>
                                <g>
                                    <path class="st0" d="M21.3,9.7c-0.6,0-1.2,0.5-1.2,1.2c0,0.7,0.5,1.2,1.2,1.2c0.7,0,1.2-0.5,1.2-1.2C22.4,10.2,21.9,9.7,21.3,9.7z">
                                    </path>
                                    <path class="st0" d="M16,11.2c-2.7,0-4.9,2.2-4.9,4.9c0,2.7,2.2,4.9,4.9,4.9s4.9-2.2,4.9-4.9C21,13.4,18.8,11.2,16,11.2z M16,19.3 c-1.7,0-3.2-1.4-3.2-3.2c0-1.7,1.4-3.2,3.2-3.2c1.7,0,3.2,1.4,3.2,3.2C19.2,17.9,17.8,19.3,16,19.3z">
                                    </path>
                                    <path class="st0" d="M20,6h-8c-3.3,0-6,2.7-6,6v8c0,3.3,2.7,6,6,6h8c3.3,0,6-2.7,6-6v-8C26,8.7,23.3,6,20,6z M24.1,20 c0,2.3-1.9,4.1-4.1,4.1h-8c-2.3,0-4.1-1.9-4.1-4.1v-8c0-2.3,1.9-4.1,4.1-4.1h8c2.3,0,4.1,1.9,4.1,4.1V20z">
                                    </path>
                                </g>
                            </g>
                        </svg></a>
                    <a rel="nofollow" href="https://www.tiktok.com/@nowyouhearus"><svg fill="#C8CBD0" width="24" height="24" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.656 1.029c1.637-0.025 3.262-0.012 4.886-0.025 0.054 2.031 0.878 3.859 2.189 5.213l-0.002-0.002c1.411 1.271 3.247 2.095 5.271 2.235l0.028 0.002v5.036c-1.912-0.048-3.71-0.489-5.331-1.247l0.082 0.034c-0.784-0.377-1.447-0.764-2.077-1.196l0.052 0.034c-0.012 3.649 0.012 7.298-0.025 10.934-0.103 1.853-0.719 3.543-1.707 4.954l0.020-0.031c-1.652 2.366-4.328 3.919-7.371 4.011l-0.014 0c-0.123 0.006-0.268 0.009-0.414 0.009-1.73 0-3.347-0.482-4.725-1.319l0.040 0.023c-2.508-1.509-4.238-4.091-4.558-7.094l-0.004-0.041c-0.025-0.625-0.037-1.25-0.012-1.862 0.49-4.779 4.494-8.476 9.361-8.476 0.547 0 1.083 0.047 1.604 0.136l-0.056-0.008c0.025 1.849-0.050 3.699-0.050 5.548-0.423-0.153-0.911-0.242-1.42-0.242-1.868 0-3.457 1.194-4.045 2.861l-0.009 0.030c-0.133 0.427-0.21 0.918-0.21 1.426 0 0.206 0.013 0.41 0.037 0.61l-0.002-0.024c0.332 2.046 2.086 3.59 4.201 3.59 0.061 0 0.121-0.001 0.181-0.004l-0.009 0c1.463-0.044 2.733-0.831 3.451-1.994l0.010-0.018c0.267-0.372 0.45-0.822 0.511-1.311l0.001-0.014c0.125-2.237 0.075-4.461 0.087-6.698 0.012-5.036-0.012-10.060 0.025-15.083z">
                            </path>
                        </svg></a>
                    <a rel="nofollow" href="https://www.facebook.com/profile.php?id=61559634242274"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                            <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z">
                            </path>
                        </svg></a>
                </div>
            </nav>
            <aside>
                <p>Copyright © 2024 - All right reserved by You Hear Us</p>
            </aside>
        </footer>
    </div>


    {{-- <script src="http://127.0.0.1:8000/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
    @yield('js')

</body>

</html>
