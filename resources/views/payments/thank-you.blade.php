@extends('layouts.app')
@section('content')
    @php
        use App\Models\Offer;

        $offer = Offer::find($payment);
    @endphp

    <div class="container mx-auto text-white my-4">
        <div class="w-1/2 mx-auto text-center">
            <h1 class="font-bold text-2xl py-10">Thank you {{ auth()->user()->band_name }} for your payment!</h1>
            <p class="text-[20px] py-10">
                "You have successfully completed the payment for the offer on your song titled <span class='font-bold'>{{ $offer->music->title }}</span>."
            </p>
            <a class="underline py-5 flex items-center justify-center space-x-2" href="{{ route('musician.music.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>
                <span>Go Back</span>
            </a>
        </div>
    </div>

@endsection
