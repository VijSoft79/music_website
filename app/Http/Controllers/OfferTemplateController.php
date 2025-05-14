<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OfferTemplate;
use App\Models\BasicOffer;
use App\Models\PremiumOffer;
use App\Models\FreeAlternative;
use App\Models\SpotifyPlaylist;
use App\Models\Offer;
use Illuminate\Auth\Events\Validated;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailToAdminForInvitationReApproval;
use App\Models\MarketingSpend;
use App\Models\SpecialAccount;
use App\Traits\FreeAltSettingTrait;
use GuzzleHttp\Promise\Create;
use PHPUnit\Framework\Constraint\IsEmpty;
use App\Helpers\NumberHelper;

class OfferTemplateController extends Controller
{
    use FreeAltSettingTrait;

    public function index()
    {

        if (!Auth::user()->profile_image_url) {

            return redirect()->route('curator.show')->withErrors(['message' => 'Please upload a profile picture']);
        }

        $offerTemplates = OfferTemplate::where('user_id', Auth::user()->id)->get();

        $data = [];
        foreach ($offerTemplates as $offerTemplate) {


            //clearing 
            $dataTargetDelete = 'data-target="#DeleteModal" data-toggle="modal" title="Delete"';
            $dataTargetEdit = 'title="Edit"';
            $editUrl = '<a href="' . route('curator.offer-templates.edit', $offerTemplate) . '">';
            $disabled = ''; // Used for disabling buttons if template is used in active offers
            $actionButtonsDisabled = $offerTemplate->is_disabled; // Disable actions if template itself is disabled

            // Existing logic to disable actions if template is used in past offers
            foreach ($offerTemplate->offer as $offer) {
                // dd($offerTemplate->offer);
                $expDate = Carbon::parse($offer->expires_at);
                if ($offerTemplate->offer->isNotEmpty()) {

                    // dd($offerTemplate->id);
                    if ($expDate->isPast()) { // Or perhaps check if status < 2 (not completed/declined)?

                        $disabled = 'disabled';
                        $dataTargetDelete = 'data-toggle="tooltip" data-placement="top" title="This Template is currently used in offer"';
                        $dataTargetEdit = $dataTargetDelete;
                        $editUrl = " ";
                        // Should we also disable the toggle button if used in active offers?
                        // $actionButtonsDisabled = true; // Uncomment if toggle should also be disabled
                    }
                }
            }

            // Prepare buttons, considering both $disabled (active use) and $actionButtonsDisabled (template disabled)
            $finalDisabledState = ($disabled === 'disabled' || $actionButtonsDisabled) ? 'disabled' : '';
            $finalDataTargetDelete = ($disabled === 'disabled' || $actionButtonsDisabled) ? $dataTargetDelete : 'data-target="#DeleteModal" data-toggle="modal" title="Delete"'; // Prevent modal trigger if disabled
            $finalDataTargetEdit = ($disabled === 'disabled' || $actionButtonsDisabled) ? $dataTargetEdit : 'title="Edit"';
            $finalEditUrl = ($disabled === 'disabled' || $actionButtonsDisabled) ? " " : '<a href="' . route('curator.offer-templates.edit', $offerTemplate) . '">';


            $btnEdit = '<button ' . $finalDataTargetEdit . ' class="btn btn-xs btn-default text-primary mx-1 shadow ' . $finalDisabledState . '">
                ' . $finalEditUrl . '
                <i class="fa fa-lg fa-fw fa-pen"></i>
                ' . (($finalEditUrl !== " ") ? '</a>' : '') . '
            </button>';

            $btnShow = '<a href="' . route('curator.offer-templates.show', $offerTemplate->id) . '" class="btn btn-xs btn-default text-info mx-1 shadow">
                <i class="fa fa-lg fa-fw fa-eye"></i>
            </a>';

            $btnDelete = '<button ' . $finalDataTargetDelete . ' class="btn btn-xs btn-default text-danger mx-1 shadow ' . $finalDisabledState . '"  id="btnDelete" data-offer-id="' . $offerTemplate->id . '">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>
                ';

            // New Toggle Button
            $toggleRoute = route('curator.offer.template.toggle', $offerTemplate);
            $toggleIcon = $offerTemplate->is_disabled ? 'fa-toggle-off' : 'fa-toggle-on';
            $toggleColor = $offerTemplate->is_disabled ? 'text-secondary' : 'text-success';
            $toggleTitle = $offerTemplate->is_disabled ? 'Enable' : 'Disable';

            $btnToggle = '<form action="' . $toggleRoute . '" method="POST" style="display: inline;">
                            ' . csrf_field() . '
                            <button type="submit" title="' . $toggleTitle . '" class="btn btn-xs btn-default ' . $toggleColor . ' mx-1 shadow">
                                <i class="fa fa-lg fa-fw ' . $toggleIcon . '"></i>
                            </button>
                        </form>';


            if ($offerTemplate->status == 0) {
                $status = "Pending";
            } elseif ($offerTemplate->is_disabled) {
                $status = "Disabled"; // Add disabled status text
            } else {
                $status = "Approved";
            }

            if (isset($offerTemplate->premiumOffer)) {
                $premiumOffer = 'yes';
            } else {
                $premiumOffer = 'no';
            }

            $rowData = [
                'id' => $offerTemplate->id, // Pass ID for row styling
                'is_disabled' => $offerTemplate->is_disabled, // Pass disabled status for row styling
                'data' => [ // Keep original data structure for datatable
                    $offerTemplate->id,
                    $offerTemplate->basicOffer->name,
                    $offerTemplate->curator->name,
                    $status, // Now includes "Disabled"
                    $premiumOffer,
                    '<nobr>'. $btnShow . $btnEdit . $btnDelete . $btnToggle . '</nobr>', // Add toggle button
                ]
            ];
            $data[] = $rowData;

        }

        return view('curator.offer-templates.index', compact(['offerTemplates', 'data'])); // Pass the modified data structure
    }

    public function create()
    {

        $isSpecial = 1;
        if (Auth::user()->special === null) {
            $isSpecialAcc = new SpecialAccount;
            $isSpecialAcc->user_id = Auth::user()->id;
            $isSpecialAcc->is_special = 1;
            $isSpecialAcc->save();


        } else {
            $isSpecial = Auth::user()->special->is_special;
        }

        return view('curator.offer-templates.create', compact('isSpecial'));
    }

    public function save(Request $request)
    {
        $rules = [
            'name' => 'required',
            'invitation_type' => 'required',
            'description' => 'required',
            'intro' => 'required',
        ];

        if (Auth::user()->special->is_special) {

            if (!$request->isspotify) {
                $additionalRules = [
                    'alternative_name' => 'required',
                    'alternative_description' => 'required',
                    'alternative_link' => 'required',
                ];
            } else {
                $additionalRules = [
                    'playlist_name' => 'required',
                    'playlist_url' => 'required|url', // Added URL validation for playlist URL
                    'song_position' => 'required|integer', // Added integer validation for song position
                    'days_of_display' => 'required|integer', // Added integer validation for days of display
                    'spotify_description' => 'required'
                ];
            }

        }

        // Merge the base rules with additional rules
        $rules = Auth::user()->special->is_special ? array_merge($rules, $additionalRules) : array_merge($rules);

        // Validate the request
        $validated = $request->validate($rules);

        $offerTemplate = OfferTemplate::create([
            'user_id' => Auth::user()->id,
            'is_active' => 0,
            'status' => 0,
            'has_premium' => 0,
        ]);


        if ($request->offer_price == null) {
            $offer_price = 0;
        } else {
            $offer_price = $request->offer_price;
        }

        // save basic offer
        $basicOffer = new BasicOffer;
        $basicOffer->name = $validated['name'];
        $basicOffer->offer_type = $validated['invitation_type'];
        $basicOffer->description = $validated['description'];
        $basicOffer->offer_price = $offer_price;
        $basicOffer->introduction_message = $validated['intro'];
        $basicOffer->offer_template_id = $offerTemplate->id;
        $basicOffer->save();

        // comment this if you dont want to use offertraits
        if (Auth::user()->special->is_special) {
            $this->FreeAltRestriction($validated, $request->isspotify, $offerTemplate->id);
        }

        //uncomment if you want to save in controller
        // if (!$request->isspotify) {
        //      // save free alternatives here
        //     $freeAlter = new FreeAlternative;
        //     $freeAlter->type = $validated['alternative_name'];
        //     $freeAlter->alter_description = $validated['alternative_description'];
        //     $freeAlter->alter_url = $validated['alternative_link'];
        //     $freeAlter->offer_template_id = $offerTemplate->id;
        //     Auth::user()->special->is_special && $freeAlter->save();//change this if condition is not special
        // }else{
        //     //save spotify playlist here
        //     $spotifyPlayList = new SpotifyPlaylist;
        //     $spotifyPlayList->offer_template_id =  $offerTemplate->id;
        //     $spotifyPlayList->playlist_name = $validated['playlist_name'];
        //     $spotifyPlayList->playlist_url = $validated['playlist_url'];
        //     $spotifyPlayList->song_position = $validated['song_position'];
        //     $spotifyPlayList->days_of_display = $validated['days_of_display'];
        //     $spotifyPlayList->description = $validated['spotify_description'];
        //     Auth::user()->special->is_special && $spotifyPlayList->save();//change this if condition is not special
        // }

        if ($request->marketingPremiumVal == 1) {

            $marketingPremium = $request->validate([
                'marketing_name_premium' => 'required',
                'marketing_spend_premium' => 'required',
                'marketing_description_premium' => 'required',
            ]);

            $marketPremium = new MarketingSpend();
            $marketPremium->name = $marketingPremium['marketing_name_premium'];
            $marketPremium->price = $marketingPremium['marketing_spend_premium'];
            $marketPremium->description = $marketingPremium['marketing_description_premium'];
            $marketPremium->offer_type = 'premium';
            $marketPremium->offertemplate_id = $offerTemplate->id;
            $marketPremium->save();
        }

        if ($request->marketingStandardVal == 1) {

            $marketingStandard = $request->validate([
                'marketing_name_standard' => 'required',
                'marketing_spend_standard' => 'required',
                'marketing_description_standard' => 'required',
            ]);

            $marketStandard = new MarketingSpend();
            $marketStandard->name = $marketingStandard['marketing_name_standard'];
            $marketStandard->price = $marketingStandard['marketing_spend_standard'];
            $marketStandard->description = $marketingStandard['marketing_description_standard'];
            $marketStandard->offer_type = 'standard';
            $marketStandard->offertemplate_id = $offerTemplate->id;
            $marketStandard->save();
        }

        if ($request->add_premium_switch == "add_premium") {
            $premiumValidated = $request->validate([
                'premium_invitation_name' => 'required',
                'premium_invitation_type' => 'required',
                'premium_invitation_description' => 'required',
                'premium_invitation_price' => 'required',
                // 'premium_invitation_intro' => 'required',
            ]);

            $premiumOffer = new PremiumOffer;
            $premiumOffer->name = $premiumValidated['premium_invitation_name'];
            $premiumOffer->description = $premiumValidated['premium_invitation_description'];
            $premiumOffer->offer_type = $premiumValidated['premium_invitation_type'];
            $premiumOffer->offer_price = $premiumValidated['premium_invitation_price'];
            $premiumOffer->introduction_message = 'No intro';
            $premiumOffer->offer_template_id = $offerTemplate->id;
            $premiumOffer->save();
            //offertype
            $offerTemplate->has_premium = 1;
            $offerTemplate->save();

        }
        return redirect()->route('curator.home');
    }

    public function show(OfferTemplate $OfferTemplate)
    {
        return view('curator.offer-templates.show', compact('OfferTemplate'));
    }

    public function edit(OfferTemplate $OfferTemplate)
    {
        $offer = $OfferTemplate->offer;
        $date = Carbon::now();
        if ($offer->where('expires_at', '<', $date)->isNotEmpty()) {
            return redirect()->route('curator.offer.template.index')->withErrors(['message' => 'This template has pending Invitations and can not be edited']);
        }
        return view('curator.offer-templates.edit', compact('OfferTemplate'));
    }

    public function update(OfferTemplate $OfferTemplate, Request $request)
    {

        $offer = $OfferTemplate->offer;
        $date = Carbon::now();

        if ($offer->where('expires_at', '<', $date)->isNotEmpty()) {
            return redirect()->route('curator.offer.template.index')->withErrors(['message' => 'Update failed the template has pending Invitations']);
        }

        $templateinOffer = $OfferTemplate->offer->where('status', '==', 2)->count();
        if ($templateinOffer) {

            return redirect()->route('curator.offer.template.index')->withErrors(['message' => 'Failed to update, the template is used offer.']);
        }

        $validated = $request->validate([
            'offerName' => 'required',
            'offerType' => 'required',
            'offerPrice' => 'required',
            'offerIntroduction' => 'required',
            'offerDescription' => 'required',
        ]);

        $offertemp = $OfferTemplate;

        // free alternative or spotify playlist edit
        if ($request->type) {
            if ($request->type == 'alter') {
                $alternativevalidated = $request->validate([
                    'alterOffername' => 'required',
                    'alterUrl' => 'required',
                    'alterdescription' => 'required',
                ]);

                // free alternative edit
                $freeAlternative = $offertemp->freeAlternative;
                $freeAlternative->type = $alternativevalidated['alterOffername'];
                $freeAlternative->alter_url = $alternativevalidated['alterUrl'];
                $freeAlternative->alter_description = $alternativevalidated['alterdescription'];
                $freeAlternative->save();

            } else {
                $alternativevalidated = $request->validate([
                    'playlist_name' => 'required',
                    'playlist_url' => 'required',
                    'song_position' => 'required',
                    'day_of_display' => 'required',
                    'description' => 'required'
                ]);

                // free alternative edit
                $playlist = $offertemp->spotifyPlayList;
                $playlist->playlist_name = $alternativevalidated['playlist_name'];
                $playlist->playlist_url = $alternativevalidated['playlist_url'];
                $playlist->song_position = $alternativevalidated['song_position'];
                $playlist->days_of_display = $alternativevalidated['day_of_display'];
                $playlist->description = $alternativevalidated['description'];
                $playlist->save();
            }


        }




        // basic offer update
        $basicOffer = $offertemp->basicOffer;
        $basicOffer->name = $validated['offerName'];
        $basicOffer->offer_type = $validated['offerType'];
        $basicOffer->description = $validated['offerDescription'];
        $basicOffer->offer_price = NumberHelper::extractNumber($validated['offerPrice']);
        $basicOffer->introduction_message = $validated['offerIntroduction'];
        $basicOffer->save();

        // premium offer update
        if (!is_null($request->premiumName)) {

            $premiumValidated = $request->validate([
                'premiumName' => 'required',
                'premiumOfferType' => 'required',
                'premiumOfferPrice' => 'required',
                'premiumDescription' => 'required',
            ]);

            $premiumOffer = $offertemp->premiumOffer;
            $premiumOffer->name = $premiumValidated['premiumName'];
            $premiumOffer->offer_type = $premiumValidated['premiumOfferType'];
            $premiumOffer->offer_price = $premiumValidated['premiumOfferPrice'];
            $premiumOffer->description = $premiumValidated['premiumDescription'];
            $premiumOffer->save();
        }

        $offertemp->status = 0;
        $offertemp->save();

        // email admin for re-approval
        Mail::to('admin@youhearus.com')->send(new EmailToAdminForInvitationReApproval($offertemp));


        return redirect()->route('curator.offer.template.index')->with('message', 'Records Updates Successfully');
    }

    public function destroy(Request $request)
    {

        $template = OfferTemplate::findOrFail($request->deleteId);
        $templateinOffer = $template->offer;

        if ($templateinOffer->isEmpty()) {

            $template->delete();
        } else {

            foreach ($templateinOffer as $templates) {

                if ($templates->status != 2) {

                    return redirect()->route('curator.offer.template.index')->withErrors(['message' => 'Failed to delete, the template is used in progress.']);
                }

            }
        }

        $template->delete();
        return redirect()->route('curator.offer.template.index')->with('message', 'Invitation Template Deleted Successfully');
    }

    /**
     * Toggle the disabled status of an OfferTemplate.
     *
     * @param OfferTemplate $offerTemplate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(OfferTemplate $offerTemplate)
    {
        // Authorization: Ensure the logged-in user owns this template
        if (Auth::id() !== $offerTemplate->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Check only when attempting to *disable* (i.e., when it's currently enabled)
        if (!$offerTemplate->is_disabled) { 
            // Prevent disabling if template is Pending Admin Approval
            if ($offerTemplate->status == 0) {
                return redirect()->route('curator.offer.template.index')->withErrors(['message' => 'Cannot disable a template that is pending approval.']);
            }
        }
        
        $offerTemplate->is_disabled = !$offerTemplate->is_disabled;
        $offerTemplate->save();

        $message = $offerTemplate->is_disabled ? 'Invitation Template disabled successfully.' : 'Invitation Template enabled successfully.';

        return redirect()->route('curator.offer.template.index')->with('message', $message);
    }

}
