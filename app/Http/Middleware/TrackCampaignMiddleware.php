<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Campaign;

class TrackCampaignMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if 'ref' parameter exists in the request
        if ($request->has('ref')) {
            $slug = $request->get('ref');
            
            // Find the campaign with the given slug
            $campaign = Campaign::where('slug', $slug)->first();
            
            // If campaign exists, increment the clicks counter
            if ($campaign) {
                $campaign->increment('clicks');
                
                // Store campaign slug in session for later use (registration tracking)
                session(['campaign_slug' => $slug]);
            }
        }
        
        return $next($request);
    }
} 