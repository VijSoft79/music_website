<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OfferTemplate;
use App\Models\Music;
use App\Models\MarketingSpend;
use App\Models\User;

class SubmissionController extends Controller
{
    public function index()
    {
        return view('curator.submissions.index');
    }

    public function show(Music $music)
    {
        $offerTemplates = OfferTemplate::where('status', 1)
                                       ->where('is_disabled', false)
                                       ->where('user_id', Auth::id())
                                       ->get();
        return view('curator.submissions.show', compact(['music', 'offerTemplates']));
    }

    public function getTemplate(OfferTemplate $offerTemplate)
    {
        if ($offerTemplate->is_disabled || $offerTemplate->user_id !== Auth::id()) {
             return response()->json(['error' => 'Template not accessible'], 403);
        }
        
        $template = OfferTemplate::where('id', $offerTemplate->id)->first();
        $marketingSpend = MarketingSpend::where('offerTemplate_id', $offerTemplate->id)->get();
        
        $premiumMarket = null;
        $standardMarket = null;

        if ($marketingSpend->isNotEmpty()) {
            $premiumMarket = $marketingSpend->where('offer_type', 'premium');
            $standardMarket = $marketingSpend->where('offer_type', 'standard');
        }

        $basicOffer = $template->basicOffer;
        
        if($template->has_premium){
            $premiumOffer = $offerTemplate->premiumOffer;
            return response()->json([
                'basicOffer' => $basicOffer, 
                'premiumOffer' => $premiumOffer,
                'template_id' =>   $template->id,
                'market_spend_premium' => $premiumMarket,
                'market_spend_standard' => $standardMarket
            ]);
        }
    
        return response()->json([
            'basicOffer' => $basicOffer,
            'template_id' =>  $template->id,
            'market_spend_premium' => $premiumMarket,
            'market_spend_standard' => $standardMarket
        ]);
    }
}
