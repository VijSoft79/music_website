<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use App\Mail\MusicPaymentSuccess;
use App\Mail\EmailToMusicianWhenSongIsFree;
use App\Mail\SongApprovalToMusician;

use App\Models\Music;
use App\Models\Coupon;
use App\Models\Price;
use App\Models\Transaction;
use App\Models\User;
use App\Services\EmailService;

class MusicPaymentController extends Controller
{
    protected $emailService;

    public function __construct()
    {
        $this->emailService = app(EmailService::class);
    }

    public function show(Request $request)
    {

        $user = Auth::user();
        $music = Music::where('id', $request->music)->first();

        if (!$music) {
            return redirect()->route('musician.index')->with('message', 'Payment process canceled');

        } else {

            if ($music->status == 'approve') {
                return redirect()->route('musician.index')->with('message', 'Your music is now available for curator');
            }
        }

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        if ($user->stripe_id == null) {
            $customer = $stripe->customers->create([
                'name' => $user->name,
                'email' => $user->email,
            ]);

            $user->stripe_id = $customer->id;
            $user->save();
        }

        if (!$music->payment) {
            Payment::create([
                'user_id' => Auth::user()->id,
                'music_id' => $music->id,
                'offer_id' => null,
                'amount' => 20000 * 0.01,
                'status' => 'unpaid'
            ]);
        }

        $price = Price::first();
        $amount = $price ? $price->amount * 100 : 20000;

        // validate the customer stripe ID first
        try {

            // validate if customer has no stripe ID
            if (!$user->stripe_id) {
                throw new \Exception('User has no Stripe customer ID.');
            }

            $intent = $stripe->paymentIntents->create([
                'amount' => $amount,
                'currency' => 'usd',
                'customer' => $user->stripe_id,
            ]);    


        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // use log for tracking error
            Log::error('Stripe customer error: ' . $e->getMessage());
            
            return redirect()->route('musician.index')->withErrors([
                'stripe' => 'Stripe customer not found or mismatched environment. Please contact the administrator',
            ]);

        } catch (\Exception $e){
            
            Log::error('Stripe customer error: ' . $e->getMessage());

            return redirect()->route('musician.index')->withErrors([
                'stripe' => 'Something went wrong while creating the payment Intent. Please contact the administrator',
            ]);

        }

        return view('payments.payment-form', [
            'intent_id' => $intent->id,
            'clientSecret' => $intent->client_secret,
            'music' => $music,
            'customer_id' => $user->stripe_id,
            'payment_method' => $request->input('payment_method_id'),
        ]);
    }
    /*
     * wala na ni
     */
    public function processPayment(Request $request)
    {
        dd('error 404 please go back to Previous Page');
        $user = Auth::user();
        $music = Music::where('id', $request->music_id)->first();
        $price = Price::first();
        $amount = $price ? $price->amount : 20;

        //coupon discount check and apply   
        if ($request->coupon_code) {

            $discountPercentage = $this->couponChecker($request->coupon_code);
            $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();

            if ($discountPercentage !== false) {

                if ($discountPercentage == 100) {

                    // change music status
                    $music->status = 'approve';
                    $music->coupon_id = $coupon->id;
                    $music->save();

                    // change payment model status
                    $payment = $music->payment;
                    $payment->status = 'paid';
                    $payment->save();

                    $music->artist->coupons()->attach($coupon->id, ['used_at' => now()]);

                    //song is 100% discount email
                    $this->emailService->send(Auth::user()->email, (new EmailToMusicianWhenSongIsFree())->forUser(Auth::user()), 'music.free', Auth::user());


                    return redirect()->route('musician.index')->with('message', 'Your song has been approved');
                }

                if ($this->couponChecker($request->coupon_code)) {
                    $discountAmount = ($amount * $discountPercentage) / 100;
                    $amount -= $discountAmount;
                }
            }

        }

        // paying here
        // $paymentIntent = Stripe::setApiKey(env('STRIPE_SECRET'));

        // $paymentIntent = PaymentIntent::create([
        //     'amount' => $amount * 100,
        //     'currency' => 'usd',
        //     'customer' => $user->stripe_id,
        //     // 'payment_method' => 'pm_card_visa',
        //     'off_session' => true,
        //     'confirm' => true,
        // ]);

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $stripe->paymentIntents->confirm(
            $request->intent_id,
            [
                'payment_method' => 'pm_card',
                'return_url' => 'https://www.example.com',
            ]
        );

        if ($stripe->status == 'succeeded') {

            // change music status
            $music->status = 'approve';
            $music->save();

            if ($request->coupon_code) {
                $music->artist->coupons()->attach($coupon->id, ['used_at' => now()]);
            }

            // change payment model status
            $payment = Payment::where('music_id', $music->id)->first();
            $payment->status = 'paid';
            $payment->save();

            Transaction::create([
                'user_id' => $music->artist->id,
                'amount' => $amount,
                'music_id' => $music->id,
                'type' => 'music-payment',
                'status' => 'complete',
            ]);

            $this->emailService->send('admin@youhearus.com', new MusicPaymentSuccess($music), 'payment.success', null);

            $message = 'Congrats! Your song is now added to our library and curators will be listening to your tune and contacting you to make arrangements to get you coverage! Continue to check your email and also the "Invitations" menu item to keep an eye on upcoming opportunities for your track.';

            return redirect()->route('musician.index')->with('message', $message);

        } else {
            return $stripe->status;
        }

    }

    public function couponChecker($couponCode)
    {

        $coupon = Coupon::where('coupon_code', $couponCode)
            ->whereDate('expire_date', '>=', now())
            ->first();

        if (!$coupon) {
            return null;
        }

        if ($coupon->discount_amount == 100) {
            return 100;
        }
        return $coupon->discount_amount;
    }

    //method if coupon exist
    public function couponExist(Request $request)
    {

        if (!$request->coupon_code) {
            return response()->json([
                'error' => 'Invalid coupon code!',
            ], 400);
        }
        $price = Price::first();
        $amount = $price ? $price->amount : 20;
        $discountPercentage = $this->couponChecker($request->coupon_code);


        if ($discountPercentage !== false) {

            $user = User::find($request->userId);
            $couponUsed = $user->coupons()->where('coupon_code', $request->coupon_code)->exists();

            if ($couponUsed) {
                return response()->json([
                    'exists' => true,
                    'already_used' => true,
                    'message' => 'This coupon has already been used.',
                    'remaining_amount' => $amount
                ]);
            }
            $percentage = $discountPercentage / 100;
            $discountAmount = $percentage * $amount;

            $remainingAmount = $amount - $discountAmount;

            return response()->json([
                'exists' => true,
                'discount' => $discountPercentage,
                'remaining_amount' => $remainingAmount,
                'amount' => $price->amount
            ]);
        } else {
            return response()->json([
                'exists' => false,
                'remaining_amount' => $amount,
            ]);
        }
    }

    public function checkout(Request $request)
    {

        if ($request->remainingAmount === null) {
            $amount = $request->price;
        } elseif ($request->remainingAmount == "0") {

            $music = Music::find($request->musicId);
            $music->status = 'approve';
            $music->save();

            return redirect()->route('musician.index');

        } elseif ($request->remainingAmount && $request->remainingAmount != "0") {
            $amount = $request->remainingAmount;

        }
        $newAmount = $amount * 100;

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => route('success.payment', ['musicId' => $request->musicId, 'amount' => $newAmount]),
            "cancel_url" => route('musician.payment.show'), // You should also define a cancel URL
            "line_items" => [
                [
                    "quantity" => 1,
                    "price_data" => [
                        "currency" => "usd",
                        "unit_amount" => $newAmount, // Amount is in cents (so $10.00 in this case)
                        "product_data" => [
                            "name" => "Song Title: " . "$request->music_title",
                            "description" => $request->music_description,

                        ]
                    ],
                ]
            ],
        ]);

        return redirect($checkout_session->url, 303);
    }

    public function successPayment(Request $request)
    {
        //convert amount
        $convertAmount = $request->amount / 100;

        if ($request->musicId) {
            $music = Music::find($request->musicId);
            $music->status = 'approve';
            $music->save();

            // Add transaction for musician
            Transaction::create([
                'user_id' => $music->artist->id,
                'amount' => $convertAmount,
                'music_id' => $music->id,
                'type' => 'music-payment',
                'status' => 'complete',
            ]);

        } else {
            return redirect()->route('musician.index')->with(['message', 'Error Music']);
        }

        $this->emailService->send(Auth::user()->email, (new EmailToMusicianWhenSongIsFree())->forUser(Auth::user()), 'music.free', Auth::user());
        $message = 'Congrats! Your song is now added to our library and curators will be listening to your tune and contacting you to make arrangements to get you coverage! Continue to check your email and also the "Invitations" menu item to keep an eye on upcoming opportunities for your track.';

        return redirect()->route('musician.index')->with('message', $message);
    }
}
