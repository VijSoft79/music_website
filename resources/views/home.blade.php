@extends('layouts.app')
@section('content')
    <div class="hero min-h-screen" style="background-image: url({{ asset('/images/pexels-david-yu-1749822levels-scaled.jpg') }});">
        <div class="hero-overlay bg-opacity-60"></div>
        <div class="hero-content text-center text-neutral-content flex-col">
            <div class="max-w2-xl">
                <h1 class="mb-5 text-5xl font-bold">Welcome to You Hear Us</h1>
                <p class="mb-5 text-xl">Submit your music to You Hear Us and open the door to exciting promotional opportunities. Get invited to be featured in campaigns by music magazines, playlist curators, and influential content creators who are always on the lookout for standout artists to spotlight on their platforms.</p>
                <a href="/choose" class="btn btn-primary">Get Started</a>
            </div>
        </div>
    </div>

    <div class="hidden md:block bg-neutral">
        <div class="w-3/5 mx-auto ">
            <div class="flex justify-center gap-28 py-8">
                <div>
                    <img class="w-[150px]" src="{{ asset('/images/home-page/youtube-logo.png') }}" alt="youtube-logo">
                </div>
                <div>
                    <img class="w-[150px]" src="{{ asset('/images/home-page/spotify.png') }}" alt="spotify-logo">
                </div>
                <div>
                    <img class="w-[80px]" src="{{ asset('/images/home-page/band-camp.png') }}" alt="band-camp-logo">
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="w-full px-4 md:w-3/5 mx-auto py-2 md:py-10">
            <div class="flex justify-center gap-5">
                <div class="hidden md:block">
                    <img class="w-[1000px]" src="{{ asset('/images/drummer.jpg') }}" alt="">
                </div>
                <div>
                    <h2 class="mb-5 text-xl md:text-3xl font-bold">For the Musician</h2>
                    <p class="mb-5 md:text-xl">
                        At You Hear Us we believe independent music deserves to be heard. We know music
                        is a true form of art and therefore we have created an affordable promotion platform focusing on
                        gaining musicians exposure and fans, not just feedback. Sign up, submit a song and get paired with
                        bloggers, stations, influencers etc..
                    </p>
                    <a href="{{ route('musician.register') }}"><button class="btn btn-primary">Register as a Musician</button></a>
                </div>

            </div>
        </div>
    </div>

    <div class="bg-neutral">
        <div class="w-full px-4 md:w-3/5 mx-auto py-2 md:py-10">
            <div class="flex justify-center gap-5">
                <div>
                    <h2 class="mb-5 text-xl md:text-3xl font-bold">For Curators</h2>
                    <p class="mb-5 md:text-xl">
                        Joining our curator team is an easy way to discover, promote and support the
                        independent music you love while getting paid for all of you hard work. Check it out..
                    </p>
                    <a href="{{ route('curator.register') }}">
                        <button class="btn btn-primary">Register as a Curator</button>
                    </a>
                </div>
                <div class="hidden md:block">
                    <img class="w-[500px]" src="{{ asset('/images/curator-page-main-image.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </div>

    {{-- featured blog post --}}
    <div class="w-full">
        <div class="mx-auto md:w-3/5 px-4 mx-3 py-5">
            <div class="w-full">
                <h3 class="text-xl md:text-3xl font-bold py-2">You might want to read</h3>
            </div>
            <div class="md:flex gap-2" id="posts-container">
                @foreach ($posts as $index => $post)
                    <div class="post w-full sm:w-1/2 min-w-[300px] p-2 md:px-10 md:py-20 mb-2 rounded-md {{ $index > 1 ? 'hidden' : 'show' }} md:show" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $post->featured_image }}'); background-repeat: no-repeat; background-size: cover;" data-index="{{ $index }}">
                        <h2 class="card-title text-[16px] md:text-3xl text-[#fff]">
                            <a href="{{ route('page.blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="text-[#fff]">{!! $post->exerpt() !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <div class="bg-neutral">
        <div class="w-3/4 mx-auto p-5 ">
            <div class="w-full md:flex p-1 mx-auto">
                <div class="hidden md:inline basis-1/2 rounded-l-lg bg-center bg-cover" style="background-image:url( {{ asset('images/contact-page-image.jpg') }} )"></div>

                <div class="basis-1 md:grow md:rounded-r-lg p-3 shadow-md">
                    <h1 class="font-bold text-3xl my-3">Contact Us</h1>
                    <div class="my-2">
                        @if (session('message'))
                            <div role="alert" class="alert alert-success">
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ session('message') }}</span>
                            </div>
                        @endif
                    </div>
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <label class="input input-bordered flex items-center gap-2 mb-4">
                            <input name="name" type="text" class="grow" placeholder="Name" />
                        </label>
                        <label class="input input-bordered flex items-center gap-2 mb-4">
                            <input name="email" type="text" class="grow" placeholder="Email" />
                        </label>
                        <textarea name="content" class="textarea textarea-bordered w-full mb-4" placeholder="Message"></textarea>
                        <button type="submit" class="btn btn-primary shadow-md">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
