<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailToCuratorForInvitationPaid;
use App\Mail\EmailToMusicianForInvitationPaid;


use App\Models\Offer;
use App\Models\BasicOffer;
use App\Models\PremiumOffer;
use App\Models\Transaction;
use App\Models\FreeAlternative;
use App\Models\SpotifyPlaylist;
use PhpParser\Node\Stmt\ElseIf_;
use Carbon\Carbon;

class InvitationPaymentController extends Controller
{
    public function show(Offer $offer, Request $request)
    {

        $chosenoffer = $this->checkOfferType($request->offerType, $request->templateId);
        $amount = $chosenoffer->offer_price == null || $chosenoffer->offer_price == 0.0 ? 0 : $chosenoffer->offer_price;

        if ($amount == null || $amount == 0) {
            $offer->status = '1';
            $offer->offer_type = $request->offerType;
            $offer->offer_type_id = $request->templateId;
            $offer->save();

            $payment = Payment::create([
                'user_id' => $offer->music->artist->id,
                'music_id' => $offer->music->id,
                'offer_id' => $offer->id,
                'amount' => $amount,
                'status' => 'paid'
            ]);

            return redirect()->route('musician.invitation.show', $offer)->with('message', 'Offer Has been successfully Approve');
        }


        if($request->offerType === 'free-option' || $request->offerType === 'spotify-playlist' ){
            $this->freeChoosen($offer->id, $request->offerType, $request->templateId);
            return back()->with('message', 'Invitation Accepted!');
        }

        $music = $offer->music;
        $musician = $music->artist;
        $curator = $offer->user;
        $template = $offer->offerTemplate;

        $chosenOffer  = $this->checkOfferType($request->offerType, $request->templateId);
        
        //check if offer is already paid
        if ($offer->status == 1) {
            return redirect()->route('musician.invitation.show', $offer)->with('message', 'This offer Is already Approved');
        }

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        if ($musician->stripe_id == null) {
            $customer = $stripe->customers->create([
                'name' => $musician->name,
                'email' => $musician->email,
            ]);

            $musician->stripe_id = $customer->id;
            $musician->save();
        }

        // check if payment exist
        $payment = Payment::where('offer_id', $offer->id)->first();
        if (!$payment) {
            $payment = Payment::create([
                'user_id' => $musician->id,
                'music_id' => $music->id,
                'offer_id' => $offer->id,
                'amount' => $chosenOffer->offer_price * 0.01,
                'status' => 'unpaid'
            ]);

            $intent = $stripe->setupIntents->create([
                'customer' => $musician->stripe_id,
                'metadata' => ['offer_id' => $offer->id]
            ]);

            $payment->stripe_setup_intent_id = $intent->id;
            $payment->save();
            
        } else {

            $intent = $stripe->setupIntents->retrieve($payment->stripe_setup_intent_id);
        }

        return view('payments.invitation-payment-form', [
            'clientSecret' => $intent->client_secret,
            'music' => $music,
            'musician_id' => $musician->stripe_id,
            'template' => $template,
            'chosenOffer' => $chosenOffer,
            'curator' => $curator,
            'offer' => $offer,
            'offerType' => $request->offerType,
        ]);
    }
    
    public function Offerpayment(Offer $offer,Request $request){
  
        
        $chosenoffer = $this->checkOfferType($request->offerType, $request->templateId);
        $amount = $chosenoffer->offer_price == null || $chosenoffer->offer_price == 0.0 ? 0 : $chosenoffer->offer_price;

        $datetime = Carbon::now();
        $date = $datetime->format('Y-m-d');
        
        if ($amount == null || $amount == 0) {
            $offer->status = '1';
            $offer->offer_type = $request->offerType;
            $offer->accepted_at = $date;
            $offer->offer_type_id = $request->templateId;
            $offer->save();
            
            Mail::to($offer->user->email)->send(new EmailToCuratorForInvitationPaid($offer));
            Mail::to($offer->music->artist->email)->send(new EmailToMusicianForInvitationPaid($offer));
            
            return redirect()->route('musician.invitation.show', $offer)->with('message', 'Offer Has been successfully Approve');
        }

        if($request->offerType === 'free-option' || $request->offerType === 'spotify-playlist' ){
            $this->freeChoosen($offer->id, $request->offerType, $request->templateId);
            return back()->with('message', 'Invitation Accepted!');
        }

        $chosenOffer = $this->checkOfferType($request->offerType, $request->templateId);

         //check if offer is already paid
        if ($offer->status == 1) {
            return redirect()->route('musician.invitation.show', $offer)->with('message', 'This offer Is already Approved');
        }

        //discount formula
        $amount = $chosenoffer->offer_price == null ? 0 : $chosenoffer->offer_price;
        $transactionFee = 4;
        $feeAmount = ($amount * $transactionFee) / 100;

        //convert cent to dollar
        $newfee = $feeAmount * 100;
        $newAmount = $amount * 100;

        $marketingPrice = 0;
        //decode the marketing_spend_option
        $marketingSpendOption = json_decode($offer->marketing_spend_option, true);
        
        //validate the offertemplate if it has a marketingspend
        if ($offer->offerTemplate->marketingSpend ||  !empty($offer->offerTemplate->marketingSpend)) {

            //marketing spend for standard offer
            //check chosen offertype if standard
            if ($request->offerType == 'standard') {

                //check marketing spend standard if required, optional, not required
                if ($marketingSpendOption[0] == "required") {
                    
                    $marketingPrice = $offer->offerTemplate->marketingSpend->where('offer_type', 'standard')->first()->price * 100;
                }elseif($marketingSpendOption[0] == 'optional'){

                    //optional button validation
                    if ($request->has('standardOptional')) {
                        
                        $marketingPrice = $offer->offerTemplate->marketingSpend->where('offer_type', 'standard')->first()->price * 100;
                    }else {
                        
                        $marketingPrice = 0;
                    }
                }else {
                    $marketingPrice = 0;
                }
            }

            //marketing spend for premium offer
            //check chosen offertype if premium
            if ($request->offerType == 'premium') {
                if ($marketingSpendOption[1] == 'required') {

                    $marketingPrice = $offer->offerTemplate->marketingSpend->where('offer_type', 'premium')->first()->price * 100;
      
                }elseif($marketingSpendOption[1] == 'optional'){

                    //optional button validation
                    if ($request->has('premiumOptional')) {
                        $marketingPrice = $offer->offerTemplate->marketingSpend->where('offer_type', 'premium')->first()->price * 100;
                    }else {
                        $marketingPrice = 0;
                    }

                }else {
                    $marketingPrice = 0;
                }
            }

        }

        //Stripe Block
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $line_items = [
            [
                "quantity" => 1,
                "price_data" => [
                    "currency" => "usd",
                    "unit_amount" => $newAmount, // Main charge
                    "product_data" => [
                        "name" => "Offer Name: " . $chosenoffer->name . " (" . $request->offerType . ")",
                        "description" => " ",
                    ],
                ],
            ],
        ];
        
        // Add "Marketing Spend" only if $marketingPrice is greater than 0
        if ($marketingPrice > 0) {
            $line_items[] = [
                "quantity" => 1,
                "price_data" => [
                    "currency" => "usd",
                    "unit_amount" => $marketingPrice,
                    "product_data" => [
                        "name" => "Marketing Spend",
                        "description" => " ",
                    ],
                ],
            ];
        }
        
        // Always add "Transaction Fee"
        $line_items[] = [
            "quantity" => 1,
            "price_data" => [
                "currency" => "usd",
                "unit_amount" => $newfee, // Extra charge (e.g. $2.00)
                "product_data" => [
                    "name" => "Transaction Fee",
                    "description" => " ",
                ]
            ],
        ];
        
        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => route('musician.invitation.pay', [
                'offer' => $offer,
                'marketingPrice' => $marketingPrice,
                'chosenoffer' => $chosenOffer,
                'offertype' => $request->offerType
            ]),
            "cancel_url" => route('musician.invitation.show', $offer),
            "line_items" => $line_items, // Use the modified line_items array
        ]);
        
        

        return redirect($checkout_session->url, 303);
    }

    public function payCurator(Offer $offer, Request $request)
    {
        $chosenOfferid = $request->query('chosenoffer');
        $chosenOffertype = $request->query('offertype');
        $marketingPrice = $request->query('marketingPrice') / 100;

        $chosenoffer = $this->checkOfferType($chosenOffertype, $chosenOfferid);
        $amount = $chosenoffer->offer_price == null ? 0 : $chosenoffer->offer_price;

        //disc formula
        $transactionFee = 4;
        $feeAmount = ($amount * $transactionFee) / 100;
        // dd($feeAmount);
        $amount = $amount + $marketingPrice;
        $music = $offer->music;
  
        //check if invitation is already approved 
        if ($offer->status == 1) {
            return redirect()->route('musician.invitation.show', $offer)->with('message', 'This offer Is already Approved');
        }

        $datetime = Carbon::now();
        $date = $datetime->format('Y-m-d');

        $offer->status = 1;
        $offer->offer_type = $chosenOffertype;
        $offer->accepted_at = $date;
        $offer->offer_type_id = $chosenoffer->id;
        $offer->save();

        //add transaction record for curator
        Transaction::create([
            'user_id' => $offer->user->id,
            'amount' => $amount,
            'type' => 'invitation-payment',
            'offer_id' => $offer->id,
            'status' => 'pending',
            'transaction_fee' => $feeAmount
        ]);

        //add transaction record for musician
        Transaction::create([
            'user_id' => $offer->music->artist->id,
            'amount' => $amount,
            'type' => 'invitation-payment',
            'offer_id' => $offer->id,
            'status' => 'completed',
            'transaction_fee' => $feeAmount
        ]);
        
        Mail::to($offer->user->email)->send(new EmailToCuratorForInvitationPaid($offer));
        Mail::to($music->artist->email)->send(new EmailToMusicianForInvitationPaid($offer));

        return redirect()->route('thankyou', ['payment' => $offer]);
    }

    public function checkOfferType($offerType, $id)
    {
        switch ($offerType) {
            case "standard":
                $chosenOffer = BasicOffer::where('id', $id)->first();
            break;

            case "premium":
                $chosenOffer = PremiumOffer::where('id', $id)->first();
            break;

            case "free-option":
                $chosenOffer = FreeAlternative::where('id', $id)->first();
            break;
                
            default:
                $chosenOffer = SpotifyPlaylist::where('id', $id)->first();
        }

        return $chosenOffer;
    }

    public function specialApprove(Request $request)
    {   
        $offer = Offer::where('id', $request->offerId)->first();
        if ($offer) {
            $offer->status = 1;
            $offer->offer_type = $request->offerType;
            $offer->offer_type_id = $request->temp;
            $offer->save();

            //make transaction.
            
            //add money to curators wallet. 
        
            return response()->json(['message' => 'Offer updated successfully'], 200); 
        } else {
            return response()->json(['message' => 'Offer not found'], 404); 
        }
    }

    public function freeChoosen($offer, $offerType, $offerTypeId)
    {
        $datetime = Carbon::now();
        $date = $datetime->format('Y-m-d');

        $offer = Offer::find($offer);
        $offer->status = 1;
        $offer->accepted_at = $date;
        $offer->offer_type = $offerType;
        $offer->offer_type_id = $offerTypeId;
        $offer->save();

        Mail::to($offer->user->email)->send(new EmailToCuratorForInvitationPaid($offer));
        Mail::to($offer->music->artist->email)->send(new EmailToMusicianForInvitationPaid($offer));
    }

}
