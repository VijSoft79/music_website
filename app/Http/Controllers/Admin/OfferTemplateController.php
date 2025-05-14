<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

use App\Models\OfferTemplate;

class OfferTemplateController extends Controller
{
    public function index()
    {

        $offertemplates = OfferTemplate::all();

        $data = [];
        foreach ($offertemplates as $OfferTemplate) {
            if ($OfferTemplate->curator) {


                $btnDeleteStat = '<a class="btn btn-xs btn-default text-danger mx-1 shadow" id="delBtn" data-toggle="modal" data-target="#deleteModal" title="Delete" data-del ="' . $OfferTemplate->id . '">
                <i class="fa fa-lg fa-fw fa-trash"></i>
            </a>';

                $btnDelete = '';

                $btnEdit = '<a href="' . route('admin.templates.edit', $OfferTemplate) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';

                if ($OfferTemplate->status == 0) {
                    $btnDelete = $btnDeleteStat;
                }

                $Tbool = false;

                if ($OfferTemplate->offer()->where('status','!=', 2)->count() > 0) {
                    $Tbool = true;
                } 

                if (!$Tbool) {
                    $btnDelete = $btnDeleteStat;
                }


                if ($OfferTemplate->status == 0) {
                    $status = '<span class="badge bg-danger">Pending Approve</span>';
                } elseif ($OfferTemplate->status == 1) {
                    $status = '<span class="badge bg-success">Approve</span>';
                } else {
                    $status = '<span class="badge bg-danger">Disapprove</span>';
                }

                $rowData = [
                    $OfferTemplate->id,
                    $OfferTemplate->basicOffer->name,
                    $OfferTemplate->curator->name,
                    $status,
                    '<nobr>' . $btnEdit . $btnDelete . '</nobr>',
                ];
                $data[] = $rowData;
            }
        }
        // $offerTemplates = $offertemplates;

        return view('admin.templates.index', compact(['data']));
    }
    public function show(OfferTemplate $OfferTemplate)
    {

        return view('admin.templates.show', compact('OfferTemplate'));
    }

    public function edit(OfferTemplate $OfferTemplate)
    {

        $templatesWithOffers = OfferTemplate::with('offer')->find($OfferTemplate);
        $data = [];
        if ($templatesWithOffers) {
            foreach ($templatesWithOffers as $OfferTemplate) {
                
                foreach ($OfferTemplate->offer as $offer) {
                $status = '';
                 switch ( $offer->status) {
                    case 0 :
                        $status= '<span class="badge bg-danger">Pending</span>';
                        break;
                    case 1 :
                        $status= '<span class="badge bg-success">Accepted</span>';
                        break;
                    case 2 :
                        $status= '<span class="badge bg-warning">Completed</span>';
                        break;
                    case 3 :
                        $status= '<span class="badge bg-secondary">Music Declined</span>';
                        break;
                    case 4 :
                        $status= '<span class="badge bg-secondary">Offer Declined</span>';
                        break;
                        
                    default:
                        $status='';
                        break;
                    }
                    
                    $rowData = [
                        $offer->id,
                        $offer->music->title ?? 'Music has been deleted',
                        $status,
                        '<nobr>' . '</nobr>',
                    ];
                    $data[] = $rowData;
                }
    
            }
        }

        return view('admin.templates.edit', compact('OfferTemplate', 'data'));
    }

    public function update(OfferTemplate $OfferTemplate)
    {
        $request = Request();

        if ($request->status == "1") {
            $OfferTemplate->status = 1;
        } else {
            $OfferTemplate->status = 2;
        }

        $OfferTemplate->save();


        return redirect()->route('admin.templates.index')->with('message', 'Offer Update Successfully');
    }

    public function delete(Request $request)
    {

        
        Offer::where('offer_template_id', $request->idDel)->delete();

        $offerTemplates = OfferTemplate::findOrFail($request->idDel);
        $offerTemplates->delete();
        

        return redirect()->route('admin.templates.index')->with('message', 'Record Successfully Deleted');
    }
}
