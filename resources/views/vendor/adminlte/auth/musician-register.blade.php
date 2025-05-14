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

@section('auth_header', 'Register As A Musician')

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

    @keyframes float {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-5px);
        }
        100% {
            transform: translateY(0px);
        }
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        50% {
            box-shadow: 0 4px 15px rgba(0,123,255,0.1);
        }
        100% {
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
    }

    .animated-card {
        animation: slideDown 0.5s ease forwards;
        opacity: 0; /* Start with invisible */
    }

    .animated-card.show {
        animation: slideDown 0.5s ease forwards;
    }

    .promo-container {
        background: linear-gradient(135deg, rgba(0,123,255,0.15) 0%, rgba(0,123,255,0.05) 100%);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(0,123,255,0.2);
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .promo-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 80% 50%, rgba(0,123,255,0.1) 0%, transparent 50%);
        animation: float 6s ease-in-out infinite;
        pointer-events: none;
    }

    .promo-container:hover {
        transform: translateY(-2px);
        animation: pulse 2s infinite;
    }

    .promo-text {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #E9ECEF;
        text-align: center;
        margin: 0;
        position: relative;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .promo-container .note-icon {
        position: absolute;
        opacity: 0.1;
        font-size: 1.5rem;
    }

    .promo-container .note-icon:nth-child(1) {
        top: 10px;
        left: 10px;
        animation: float 4s ease-in-out infinite;
    }

    .promo-container .note-icon:nth-child(2) {
        bottom: 10px;
        right: 10px;
        animation: float 5s ease-in-out infinite reverse;
    }

    /* Testimonial Styles Updated */
    .testimonial-section {
        margin-top: 2rem; /* Reduced margin slightly */
        padding: 3rem 0;
        /* Removed background-color to blend with page */
        border-top: 1px solid rgba(255, 255, 255, 0.1); /* Subtle separator */
    }
    .testimonial-card {
        background-color: #2d3748; /* Darker card background */
        color: #cbd5e0; /* Slightly softer light text color */
        border: 1px solid rgba(255, 255, 255, 0.1); /* Subtle border */
        border-radius: 10px; /* Slightly larger radius */
        padding: 1.75rem; /* Increased padding */
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* Adjusted shadow */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(144, 205, 244, 0.15); /* Use accent color shadow on hover */
    }
    .testimonial-quote {
        font-style: italic;
        margin-bottom: 1.25rem; /* Increased margin */
        font-size: 1.05rem; /* Slightly larger font */
        line-height: 1.7;
        color: #e2e8f0; /* Brighter quote text */
    }
    .testimonial-author {
        font-weight: bold;
        text-align: right;
        color: #90cdf4; /* Existing Accent color */
    }
    .testimonial-author span {
        display: block;
        font-weight: normal;
        font-size: 0.9rem;
        color: #a0aec0; /* Lighter secondary text */
    }

    /* Video Section Styles - Updated */
    .video-section {
        margin-top: 3rem;
        padding: 2rem 0; /* Reduced padding, will be handled by outer card */
        text-align: center;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    /* New: Outer card for the whole video section */
    .video-section-card {
        background-color: rgba(45, 55, 72, 0.8); /* Slightly transparent dark background */
        border-radius: 15px; /* Larger radius for outer card */
        padding: 2.5rem; /* Generous padding */
        margin-bottom: 2rem; /* Space below the card */
         box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    .video-section-heading {
        font-size: 1.8rem; /* Increased size */
        font-weight: 600; /* Bolder */
        color: #f8f9fa; /* Brighter white */
        margin-bottom: 2.5rem;
        text-align: center;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5); /* Add subtle shadow */
    }
    .video-container {
        display: flex;
        justify-content: center;
        gap: 2rem; /* Increased gap */
        flex-wrap: wrap;
    }
    /* Style for the individual video card (Simplified) */
    .video-card {
        position: relative; /* Needed for absolute positioning of button */
        /* Removed background/padding/shadow - now handled by outer card */
        border-radius: 10px; 
        width: 200px; /* Keep video width */
        height: 355px; /* Keep video height */
        display: inline-block;
         /* Removed border-top and transitions related to it */
        transition: transform 0.3s ease; /* Simpler transition */
        overflow: hidden; /* Ensure video corners obey radius */
    }
     .video-card:hover {
        transform: scale(1.03); /* Scale effect on hover */
        /* Removed shadow/border changes */
    }
    /* Style for the actual video */
    .testimonial-video {
        width: 100%; /* Fill the container */
        height: 100%; /* Fill the container */
        border-radius: 10px; /* Match parent card radius */
        object-fit: cover;
        display: block;
        margin: 0 auto;
        background-color: #4a5568;
    }
    /* Style for unmute button - Adjusted */
    .unmute-button {
        position: absolute;
        top: 10px; /* Back to simpler positioning */
        right: 10px; /* Back to simpler positioning */
        z-index: 10;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        font-size: 0.9rem;
        line-height: 30px;
        text-align: center;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }
    .unmute-button:hover {
        opacity: 1;
    }

    /* Heading Styles - Enhanced */
    .fancy-heading {
        font-family: 'Poppins', sans-serif;
        font-size: 1.8rem; /* Increased size */
        font-weight: 700;
        color: #429edb; /* Slightly brighter accent color */
        text-align: center;
        margin-bottom: 1.8rem; /* Adjusted spacing */
        text-shadow: 0 2px 5px rgba(0, 0, 0, 0.4); /* Enhanced shadow */
        animation: pulse-text 4s infinite ease-in-out; /* Subtle animation */
    }

    @keyframes pulse-text {
        0% { opacity: 0.9; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.02); }
        100% { opacity: 0.9; transform: scale(1); }
    }

    </style>
@endpush

@section('auth_body')
    <div class="promo-container">
        <i class="fas fa-music note-icon"></i>
        <i class="fas fa-music note-icon"></i>
        <p class="promo-text">
            Submit your music to You Hear Us and take the next step in your music career. By registering, you'll get your songs in front of top music magazines, playlist curators, and influential tastemakers actively searching for fresh new talent to feature on their platforms.
        </p>
    </div>

    <div class="d-none" id="warning">
        <x-adminlte-alert theme="warning" title="Warning">
            We will be taking artist registrations soon. If you would like to be notified when are ready enter your name, band name, and contact info.
        </x-adminlte-alert>
    </div>
    @if ($errors->has('$attribute'))
        <div class="alert alert-danger">
            {{ $errors->first('$attribute') }}
        </div>
    @endif
    <form action="{{ route('musician.register.save') }}" method="post" id="registerForm2">
        @csrf
        <input name="user_role" type="hidden" value="musician">

        {{-- Name field --}}    
        <div class="input-group mt-4 mb-3">
            <input type="text" name="band_name" class="form-control @error('band_name') is-invalid @enderror" value="{{ old('band_name') }}" placeholder="Band Name" id="name_field" autofocus>

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

        <input type="hidden" name="page-token" value="<?php echo strtoupper(substr(bin2hex(random_bytes(4)), 0, 8)); ?>">


        <div class="g-recaptcha" data-sitekey="6LewNd0qAAAAAJ5lDOcIvkzzd0Y33ynlFTD4rlVC"></div>
        
        {{-- Register button --}}
        <button  class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }} mt-5">
            <span class="fas fa-user-plus"></span>
            {{ __('adminlte::adminlte.register') }}
        </button>
    </form>
@stop

{{-- New section for content outside the main card --}}
@section('page_specific_content_after_card')
<div class="container py-4"> 

    {{-- Testimonials Section --}}
    <section class="testimonial-section" id="testimonials">
        <div class="container">
            <div class="row">
                {{-- Testimonial 1 --}}
                <div class="col-md-6">
                    <div class="testimonial-card">
                        <p class="testimonial-quote">"We weren't sure what to expect, but You Hear Us gave us exposure we weren't getting elsewhere. It's cool to know curators are actually looking for music like ours."</p>
                        <p class="testimonial-author">— Tyler <span>from The Wake Ups, alt-rock band</span></p>
                    </div>
                </div>
                {{-- Testimonial 2 --}}
                <div class="col-md-6">
                    <div class="testimonial-card">
                        <p class="testimonial-quote">"I was surprised how easy it was to use. Within a day of uploading, my song got picked up for several blog posts — it gave me a nice bump in streams and followers!"</p>
                        <p class="testimonial-author">— Maya Elen <span>folk/pop musician</span></p>
                    </div>
                </div>
                {{-- Testimonial 3 --}}
                <div class="col-md-6">
                    <div class="testimonial-card">
                        <p class="testimonial-quote">"I've tried a bunch of promo platforms, but You Hear Us was actually worth it. Got real feedback, real exposure, and it didn't feel like I was shouting into the void."</p>
                        <p class="testimonial-author">— JAYVON <span>hip-hop artist</span></p>
                    </div>
                </div>
                {{-- Testimonial 4 --}}
                <div class="col-md-6">
                    <div class="testimonial-card">
                        <p class="testimonial-quote">"Love how direct the platform is. No fluff, just upload your track and let the curators do their thing. Got a bunch of placements and some solid new ears on my work."</p>
                        <p class="testimonial-author">— NEONSTEP <span>electronic producer</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Video Section --}}
    <section class="video-section">
        <div class="container">
            {{-- Wrap content in an outer card --}}
            <div class="video-section-card">
                {{-- Add Section Heading --}}
                <h3 class="video-section-heading">Hear From Our Musicians</h3>
                <div class="video-container">
                    {{-- Video 1 --}}
                    <div class="video-card">
                        <video id="testimonialVideo1" class="testimonial-video" autoplay muted loop playsinline>
                            <source src="{{ asset('videos/testimonial_video_1.mp4') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <button class="unmute-button" data-video-target="testimonialVideo1">
                            <i class="fas fa-volume-mute"></i>
                        </button>
                    </div>
                    {{-- Video 2 --}}
                    <div class="video-card">
                        <video id="testimonialVideo2" class="testimonial-video" autoplay muted loop playsinline>
                            <source src="{{ asset('videos/testimonial_video_2.mov') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                         <button class="unmute-button" data-video-target="testimonialVideo2">
                            <i class="fas fa-volume-mute"></i>
                        </button>
                    </div>
                </div>
            </div> {{-- End video-section-card --}}
        </div>
    </section>
</div> {{-- Close added container --}}
@endsection

@section('js')
{{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}

<script>
   
    function onSubmit(token) {
        document.getElementById("registerForm2").submit();
    }

    // Auto-scroll to testimonials on page load
    window.addEventListener('load', (event) => {
        const testimonialsSection = document.getElementById('testimonials');
        if (testimonialsSection) {
            setTimeout(() => {
                testimonialsSection.scrollIntoView({ behavior: 'smooth' });
            }, 100);
        }

        // Add event listeners for unmute buttons
        document.querySelectorAll('.unmute-button').forEach(button => {
            button.addEventListener('click', () => {
                const videoId = button.getAttribute('data-video-target');
                const video = document.getElementById(videoId);
                const icon = button.querySelector('i');

                if (video && icon) {
                    video.muted = !video.muted;
                    if (video.muted) {
                        icon.classList.remove('fa-volume-up');
                        icon.classList.add('fa-volume-mute');
                    } else {
                        icon.classList.remove('fa-volume-mute');
                        icon.classList.add('fa-volume-up');
                    }
                }
            });
        });
    });
</script>
@stop
@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@stop
