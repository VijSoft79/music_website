<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminSetting;
use Stripe\Tax\Settings;

class AdminSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = AdminSetting::all();

        

        return view('admin.setting', compact('settings'));
    }

    public function changestat(Request $request){
        // dd($request->switchValue);
        $settings = AdminSetting::where('name', $request->switchId)->first();
             
            if ($settings) {
                // dd($request->switchValue);
                $settings->status = $request->switchValue == "false" ? 0 : 1;
                $settings->save();
                
            }else{
                // dd('false');
                AdminSetting::create([
                    'name' => $request->switchId,
                    'status' => $request->switchValue == false ? 0 : 1,
                ]);
            }
        
       
    
        
        return view('admin.setting');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
