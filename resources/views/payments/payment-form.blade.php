@extends('layouts.app')
@section('content')
    <div class="container mx-auto text-white my-4">
        <div class="w-1/2 p-5 bg-neutral shadow-xl rounded mx-auto">
            <div class="h-full flex">
                <div class="basis-3/4 p-3 h-full">
                    <h2 class="card-title mb-3 text-[25px]">Confirmation</h2>
                    <p class="text-lg mb-10 text-justify mr-4">
                        We are delighted to inform you that your song <b>"{{ $music->title }}"</b> has been approved by our team. Please pay the stated Amount. We were truly impressed with your creativity and talent, and we believe this track will be a fantastic addition to our collection.
                    </p>
                    <div class="w-full flex font-bold border border-yellow-500 p-3 rounded-full mt-auto bg-[#212D63]">
                        <div class="w-1/2 p-2 text-[20px]">
                            Amount:
                        </div>
                        @php
                            $price = App\Models\Price::first();
                        @endphp
                        <div class="w-1/2 p-2 text-[20px] text-right">
                            ${{ number_format($price->amount, 2) }}
                        </div>
                    </div>
                </div>
                <div class="grow">
                    <!-- form structure remains unchanged -->
                    <form action="{{ route('musician.payment.proceed') }}" id="payment-form" method="post">
                        @csrf
                        <input type="hidden" name="music_title" value="{{ $music->title }}">
                        <input type="hidden" name="price" value="{{$price->amount}}">
                        <input type="hidden" name="musicId" value="{{$music->id}}">
                        <input type="hidden" name="remainingAmount" id="remainingAmount">
                        <input type="hidden" name="music_description" value="{{$music->description}}">

                        <div id="payment-element">
                            <!--Stripe.js injects the Payment Element-->
                        </div>

                        <!-- Coupon form -->
                        <div class="mt-10">
                            <label for="coupon_code" class="font-bold">Have a Coupon?</label>
                            <input class="w-full border border-yellow-500 p-3 mt-3 rounded-lg bg-[#212D63]" type="text" name="coupon_code" id="coupon_code">
                            <div id="coupon-message" class="text-red-500 absolute mt-1"></div>
                            <div id="remaining-amount" class="text-white absolute mt-6"></div>
                        </div>
                        

                        <div class="relative h-56">
                            <!-- Other content -->
                            <div class="card-actions absolute bottom-0 right-0 justify-end">
                              <!-- Place buttons or actions here -->
                              <button id="submitbtn" class="btn btn-primary">Proceed</button>
                              <div id="error-message"></div>
                            </div>
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
        // const cardElement = elements.create('card');
        // cardElement.mount('#payment-element');

        // document.getElementById('payment-form').addEventListener('submit', async (event) => {
        //     event.preventDefault();

        //     const {
        //         error
        //     } = await elements.submit();

        //     const {
        //         paymentMethod
        //     } = await stripe.createPaymentMethod({
        //         type: 'card',
        //         card: cardElement, // Make sure 'paymentElement' is correctly initialized
        //     });

        //     console.log(paymentMethod); // Add this for debugging
        //     console.log(error); // Add this for debugging

        //     if (error) {
        //         const errorMessage = document.getElementById('error-message');
        //         errorMessage.textContent = error.message;
        //     } else {
        //         const form = document.getElementById('payment-form');
        //         // form.submit();
        //     }
        // });

        // const elements = stripe.elements(options);
        // const paymentElement = elements.create('payment');  // Keep 'payment' element for multiple payment methods
        // paymentElement.mount('#payment-element');

        // document.getElementById('payment-form').addEventListener('submit', async (event) => {
        //     event.preventDefault();

        //     // Confirm the payment instead of manually creating a PaymentMethod
        //     const { error } = await elements.submit();

        //     console.log(elements);

        //     if (error) {
        //         const errorMessage = document.getElementById('error-message');
        //         errorMessage.textContent = error.message;
        //     }else{
        //         const form = document.getElementById('payment-form');
        //         form.submit();
        //     }
        // });


        // document.getElementById('payment-form').addEventListener('submit', async (event) => {
        //     event.preventDefault();

        //     // Create a Payment Method using Stripe.js
        //     const {
        //         paymentMethod,
        //         error
        //     } = await stripe.createPaymentMethod({
        //         type: 'card',
        //         card: paymentElement, // Make sure 'paymentElement' is correctly initialized
        //     });

        //     console.log(paymentMethod); // Add this for debugging
        //     console.log(error); // Add this for debugging

        //     if (error) {
        //         // Show error to the user if there's any issue
        //         const errorMessage = document.getElementById('error-message');
        //         errorMessage.textContent = error.message;

        //         // Re-enable the submit button
        //         document.getElementById('submitbtn').disabled = false;
        //     } else {
        //         // If no error, set the payment_method_id in the hidden input field
        //         document.getElementById('payment-method-id').value = paymentMethod.id;

        //         // Now submit the form to the server
        //         document.getElementById('payment-form').submit();
        //     }
        // });

        // Validate coupon
        document.getElementById('coupon_code').addEventListener('input', function() {
            let couponCode = this.value;
            const couponMessage = document.getElementById('coupon-message');
            const remainingAmountElement = document.getElementById('remaining-amount');
            const submitBtn = document.getElementById('submitbtn');

            if (couponCode) {
                submitBtn.disabled = true;
                fetch('{{ route('coupon.validate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            coupon_code: couponCode,
                            userId: {{ $music->artist->id }},
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            if (data.already_used) {
                                couponMessage.textContent = 'This coupon has already been used!';
                                couponMessage.classList.remove('text-green-500');
                                couponMessage.classList.add('text-red-500');
                                submitBtn.disabled = true;
                            } else {
                                
                                if (data.remaining_amount == data.amount) {
                                    couponMessage.textContent = 'Invalid coupon code!';
                                    couponMessage.classList.remove('text-green-500');
                                    couponMessage.classList.add('text-red-500');
                                    remainingAmountElement.textContent = 'Remaining Amount: $' + (data.remaining_amount);
                                    submitBtn.disabled = true;

                                }else {
                                    couponMessage.textContent = 'Coupon applied successfully!';
                                    couponMessage.classList.remove('text-red-500');
                                    couponMessage.classList.add('text-green-500');
                                    remainingAmount.value = data.remaining_amount;
                                    remainingAmountElement.textContent = 'Remaining Amount: $' + (data.remaining_amount);
                                    submitBtn.disabled = false;
                                }

                            }
                        } else {

                            couponMessage.textContent = 'Invalid coupon code!';
                            couponMessage.classList.remove('text-green-500');
                            couponMessage.classList.add('text-red-500');
                            remainingAmountElement.textContent = 'Remaining Amount: ' + data.remaining_amount;
                            submitBtn.disabled = true;
                        }
                    })
                    .catch(error => {
                        if (couponCode === '' || couponCode == null) {
                            submitBtn.disabled = false;
                            couponMessage.textContent = '';
                            couponMessage.classList.remove('text-green-500');
                            couponMessage.classList.add('text-red-500');

                        } else {
                            if (couponCode) {
                                return coupon = null;
                            } else {
                                console.error('Error:', error);
                                couponMessage.textContent = 'An error occurred. Please try again.';
                                couponMessage.classList.remove('text-green-500');
                                couponMessage.classList.add('text-red-500');
                                remainingAmountElement.textContent = '';
                                submitBtn.disabled = true;
                            }
                        }
                    });
            } else {

                couponMessage.textContent = '';
                couponMessage.classList.remove('text-green-500', 'text-red-500');
                remainingAmountElement.textContent = '';
                submitBtn.disabled = false;
            }
        });

       
    </script>
@endsection
