<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::all();

        $data = [];
        foreach ($coupons as $coupon) {
            // $btnEdit = '<a href="' .  route('admin.templates.show', $coupon->id). '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
            //     <i class="fa fa-lg fa-fw fa-pen"></i>
            // </a>';
            // $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
            //         <i class="fa fa-lg fa-fw fa-trash"></i>
            //     </button>';
            // $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
            //         <i class="fa fa-lg fa-fw fa-eye"></i>
            //     </button>';

            $rowData = [
                $coupon->id,
                $coupon->name,
                $coupon->coupon_code,
                $coupon->status,
                $coupon->expire_date,
                $coupon->discount_amount . '%',
                // '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>',
            ];
            $data[] = $rowData;
        }

        return view('admin.coupons.index', compact(['data']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'coupon_code' => 'required',
            'expire_date' => 'required',
            'discount_amount' => 'required',
        ]);

        Coupon::create([
            'name' => $validated['name'],
            'coupon_code' => $validated['coupon_code'],    
            'expire_date'=> Carbon::createFromFormat('m/d/Y', $validated['expire_date'])->format('Y-m-d'),
            'discount_amount'=> $validated['discount_amount']
        ]);

        return redirect()->route('coupon.index')->with('success','coupon has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        //
    }

    public function generateKey()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz12345678910';
        $charactersLength = strlen($characters);

        do {
            $randomString = '';
            for ($i = 0; $i < 4; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            $couponExist = Coupon::where('coupon_code', $randomString)->first();
        } while ($couponExist);

        return response()->json(['key' => $randomString]);
    }


}
