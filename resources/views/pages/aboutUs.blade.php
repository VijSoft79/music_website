@extends('layouts.app')

@section('title')
    - About Us
@endsection

@section('content')
    <div class="w-3/4 mx-auto p-10 mt-10">
        <div class="md:flex p-1 gap-6 mx-auto ">
            <div class="basis-2/6 rounded-l-lg" style="">
                <img src="{{ asset('/images/about-page/aboutimg.png') }}" class="w-full h-full rounded-lg shadow-2xl" />
            </div>

            <div class="basis-4/6 rounded-r-lg text-justify text-lg">
                <h1 class="text-2xl md:text-5xl font-bold">About Us</h1>
                <p class="mt-8">
                    At You Hear Us, we believe that every independent artist deserves a platform to showcase their talent and be heard. Our mission is simple: to connect musicians with curators who are passionate about discovering and promoting fresh music.
                    We've created an accessible and affordable solution where artists can submit their songs and gain exposure from bloggers, radio stations, influencers, and more. 
                    For musicians, we provide an easy-to-use submission system that helps your music reach the right audience. Whether you're looking for feedback, playlist placement, 
                    or promotional features, we work to ensure your art gets the attention it deserves.
                </p>
                <p class="mt-5">
                    For curators, we offer a unique opportunity to connect with artists, build relationships, and support independent music while earning for your promotional efforts. Our goal is to foster genuine connections that lead to meaningful exposure for artists and growth for curators.
                    You Hear Us is more than just a music platform—it's a community that celebrates the art of music, supports creativity, and empowers both musicians and curators to thrive. Join us and let your voice be heard.
                </p>

            </div>
        </div>
    </div>

@endsection