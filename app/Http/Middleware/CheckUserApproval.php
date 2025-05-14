<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user
            $user = Auth::user();
            
            // Check if the user has any of the specified roles
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    // User has the required role, so allow access
                    return $next($request);
                }
            }
            
            // User doesn't have any of the specified roles, redirect them to a page
            return redirect()->route('/');
        }
        
        // User is not authenticated, redirect them to login page
        return redirect()->route('login');
    }
}
