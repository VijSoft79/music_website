@extends('layouts.app')

@section('title')
    - Contact
@endsection

@section('content')
    <div class="w-3/4 mx-auto p-5 ">

        <div class="w-full md:flex md:w-2/4 p-1 mx-auto">
            <div class="hidden md:inline basis-2/6 rounded-l-lg bg-center bg-cover"
                style="background-image:url( {{ asset('images/contact-page-image.jpg') }} )"></div>

            <div class="basis-1 md:basis-4/6 rounded-r-lg p-3 shadow-md border">
                <h1 class="font-bold text-3xl my-3">Contact Us</h1>
                <div class="my-2">
                    @if (session('message'))
                        <div role="alert" class="alert alert-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
@endsection
