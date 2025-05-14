@extends('layouts.app')

@section('content')
<style>
    #method-element {
        background-color: #212D63;
        border: 1px solid var(--colorPrimary);
        padding: 10px;
        border-radius: 8px;
    }
</style>
    <div class="w-[30%] mx-auto text-white my-4">
        <div class="container">
            <p class="py-4">Please fill out this form to where your money will be send.</p>
            <form id="payment-form" action="{{ route('withdraw.request') }}" method="post">
                @csrf
                <x-adminlte-input name="user" type="hidden" value="{{ Auth()->user()->id }}"/>
                <div id="method-element">
                    <!--Stripe.js injects the Payment Element-->
                </div>
                <div class="mt-2" id="card-errors" role="alert"></div>
                <div class="card-actions justify-start mt-3">
                    <button id="submitButton" class="btn btn-primary">Add Payment Method</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();
        // Create an instance of the card Element.
        const card = elements.create('card', {
            style: {
                base: {
                    color: 'white',
                    fontFamily: 'Sohne, system-ui, sans-serif',
                    fontWeight: '500',
                    fontSize: '16px',
                    iconColor: 'white',
                    '::placeholder': {
                        color: '#ABB2BF', // Placeholder color
                    },
                },
                complete: {
                    color: '#4CAF50', // Change to a color indicating successful input
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a', // Error color
                },
            },
            hidePostalCode: true, // Optionally hide the postal code field
        });

        card.mount('#method-element');

        // Handle real-time validation errors from the card Element
        card.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        const form = document.getElementById('payment-form');
        
        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            // Send a request to your server to create a PaymentMethod for the customer.
            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                '{{ $clientSecret }}', {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: '{{ Auth::user()->name }}',
                        },
                    },
                }
            );

            if (error) {
                // Show error to your customer.
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                // The card has been verified and can be used as a payment method.
                // Send the payment method ID to your server.
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method_id');
                hiddenInput.setAttribute('value', setupIntent.payment_method);
                form.appendChild(hiddenInput);

                form.submit(); // Now this will call the correct form submit method.
            }
        });
    </script>
@endsection
