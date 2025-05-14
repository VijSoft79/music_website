@extends('layouts.app')
@section('content')
    <div class="container mx-auto text-white my-4">
        <div class="w-3/4 p-10 bg-neutral shadow-xl mx-auto rounded-md">
            <div class="flex gap-4">
                <div class="basis-1/2">
                    <h2 class="text-2xl mb-2 font-bold">Invitation Details</h2>
                    <div class="mb-5">
                        {{-- type --}}
                        <dl class="">
                            <dt class="font-bold">Type</dt>
                            <dd>{{ $chosenOffer->offer_type }}</dd>
                        </dl>

                        {{-- description --}}
                        <dl class="">
                            <dt class="font-bold">Description</dt>
                            <dd>{!! $chosenOffer->description !!}</dd>
                        </dl>

                        
                    </div>

                    {{-- <div class="">
                        <h2 class="text-2xl mb-2 font-bold">Alternative</h2>
                        <dl>
                            <dt class="font-bold">Type:</dt>
                            <dd>{{ $template->freeAlternative->type }}</dd>

                            <dt class="font-bold">Url:</dt>
                            <dd>{{ $template->freeAlternative->alter_url }}</dd>

                            <dt class="font-bold">Description</dt>
                            <dd>{!! $template->freeAlternative->alter_description !!}</dd>
                        </dl>
                    </div> --}}
                </div>
                <div class="basis-1/2">
                    <form action="{{ route('musician.invitation.pay', $offer) }}" id="payment-form" method="POST">
                        @csrf
                        <input type="hidden" name="offerType" value="{{ $offerType }}">
                        <input type="hidden" name="chosen" value="{{ $chosenOffer->id }}">
                        <div id="payment-element">
                            <!--Stripe.js injects the Payment Element-->
                        </div>

                        {{-- curator fee --}}
                        <div class="flex w-full mx-auto p-2 px-5">
                            <div class="w-50">
                                <span class="text-20">
                                    Curator Price
                                </span>
                            </div>
                            <div class="flex w-50 text-right ml-auto">
                                <div class="font-bold text-20">
                                    $ {{ number_format($chosenOffer->offer_price, 2) }}
                                </div>
                            </div>
                        </div>

                        {{-- transaction fee --}}
                        <div class="flex w-full mx-auto p-2 px-5">
                            <div class="w-50">
                                <span class="text-20">
                                    Transaction Fee
                                </span>
                            </div>
                            <div class="flex w-50 text-right ml-auto">
                                <div class="font-bold text-20">
                                    $ {{ number_format(($chosenOffer->offer_price * 4) / 100, 2) }}
                                </div>
                            </div>
                        </div>

                        {{-- total amount --}}
                        <div class="flex w-full border rounded-full mx-auto p-2 px-5 my-5">
                            <div class="w-50">
                                <span class="font-bold text-20">
                                    Total Amount
                                </span>
                            </div>
                            <div class="flex w-50 text-right ml-auto">
                                <div class="font-bold text-20">
                                    $ {{ $chosenOffer->offer_price ? number_format(($chosenOffer->offer_price * 4) / 100 + $chosenOffer->offer_price, 2) : 'Free' }}
                                </div>
                            </div>
                        </div>
                        <div class="card-actions justify-start mt-3">
                            <button id="submit" class="btn btn-primary">Pay</button>
                            <div id="error-message"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');

        const options = {
            clientSecret: '{{ $clientSecret }}',
            appearance: {
                theme: 'night',
                variables: {
                    fontFamily: 'Sohne, system-ui, sans-serif',
                    fontWeightNormal: '500',
                    borderRadius: '8px',
                    colorBackground: '#0A2540',
                    colorPrimary: '#EFC078',
                    accessibleColorOnColorPrimary: '#1A1B25',
                    colorText: 'white',
                    colorTextSecondary: 'white',
                    colorTextPlaceholder: '#ABB2BF',
                    tabIconColor: 'white',
                    logoColor: 'dark'
                },
                rules: {
                    '.Input': {
                        backgroundColor: '#212D63',
                        border: '1px solid var(--colorPrimary)'
                    }
                }
            }
        };

        const elements = stripe.elements(options);

        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');
    </script>
@endsection
