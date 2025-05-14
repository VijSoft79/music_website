<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->get();
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaigns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:campaigns,slug|regex:/^[a-zA-Z0-9\-]+$/',
        ]);

        // If no slug is provided, generate one from the name
        $slug = $request->slug ?: Str::slug($request->name) . '-' . Str::random(6);

        Campaign::create([
            'name' => $request->name,
            'slug' => $slug,
            'clicks' => 0,
            'registrations' => 0,
        ]);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign created successfully.');
    }

    public function show(Campaign $campaign)
    {
        return view('admin.campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:campaigns,slug,' . $campaign->id . '|regex:/^[a-zA-Z0-9\-]+$/',
        ]);

        // If slug is provided, use it, otherwise keep the existing one
        $slug = $request->slug ?: $campaign->slug;

        $campaign->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign deleted successfully.');
    }
} 