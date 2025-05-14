<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

use Illuminate\Support\Facades\Mail;
use App\Mail\MusicPaymentSuccess;

use App\Models\Music;
use App\Models\Coupon;
use App\Models\Price;
use App\Models\Transaction;

class PaymentController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $music = Music::where('id', $request->music)->first();

        // free on 100 first song.
        // if($this->getMusicPosition($music) <= 100 ){
        //     return redirect()->route('musician.music.index')->with('message', 'Your music is now available for curator');
        // }

        if ($music->status == 'approve') {
            return redirect()->route('musician.music.index')->with('message', 'Your music is now available for curator');
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

        $intent = $stripe->setupIntents->create([
            'customer' => $user->stripe_id
        ]);

        

        return view('payments.payment-form', [
            'clientSecret' => $intent->client_secret,
            'music' => $music,
            'customer_id' => $user->stripe_id,
        ]);
    }

    public function processPayment(Request $request)
    {

        $user = Auth::user();
        $music = Music::where('id', $request->music_id)->first();
        $price =  Price::first();
        if(!$price){
            $amount = 20;
        }else{
            $amount = $price->amount;
        }

        if ($music->status == 'approve') {
            return view('payments.thank-you', [
                'payment' => $music->payment
            ]);
        }

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

                    return view('payments.thank-you', [
                        'payment' => $payment
                    ]);
                }

                if ($this->couponChecker($request->coupon)) {
                    $discountAmount = ($amount * $discountPercentage) / 100;
                    $amount -= $discountAmount;
                }
            }
        }

        // paying here
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'customer' => $user->stripe_id,
            'payment_method' => 'pm_card_visa',
            'off_session' => true,
            'confirm' => true,
        ]);

        if ($paymentIntent->status == 'succeeded') {

            // change music status
            $music->status = 'approve';
            $music->save();

            if ($request->coupon_code) {
                //change coupon status
                $coupon->status = 'used';
                $coupon->save();
            }
         
            // change payment model status
            $payment = Payment::where('music_id', $music->id)->first();
            $payment->status = 'paid';
            $payment->save();

            Transaction::create([
                'user_id' => $music->artist->id,
                'amount' => $amount,
                'type' => 'music-payment',
                'status' => 'complete',
            ]);

            Mail::to('admin@youhearus.com')->send(new MusicPaymentSuccess($music));

            return view('payments.thank-you', [
                'payment' => $payment
            ]);

        } else {
            return $paymentIntent->status;
        }
    }

    public function getMusicPosition($music)
    {
        $allMusic = Music::all();

        // Get the position of the specific item
        $position = $allMusic->search(function ($item) use ($music) {
            return $item->id == $music->id;
        });

        $placeNumber = $position !== false ? $position + 1 : null;
        return $placeNumber;
    }

    public function couponChecker($coupon)
    {
        $coupon = Coupon::where('coupon_code', $coupon)
            ->where('status', 'unused')
            ->whereDate('expire_date', '>=', now())
            ->first();

        if ($coupon->discount_amount == 100) {
            return 100;
        }
        return $coupon->discount_amount;
    }

    public function couponExist(Request $request)
    {
        $amount = 20000; // Original amount
        $discountPercentage = $this->couponChecker($request->coupon_code);

        if ($discountPercentage !== false) {
            $discountAmount = ($amount * $discountPercentage) / 100;
            $remainingAmount = $amount - $discountAmount;
            return response()->json(['exists' => true, 'discount' => $discountPercentage, 'remaining_amount' => $remainingAmount]);
        } else {
            return response()->json(['exists' => false, 'remaining_amount' => $amount]);
        }
    }
}
