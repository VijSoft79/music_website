<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;


class UnderConstruction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->name != 'SpecialCurator' || Auth::user()->name != 'SpecialMusician') {

            if( Auth::user()->special && Auth::user()->special->is_special){
                return $next($request);
            }
            
            if(Auth::user()->name == 'Hella Fuzz'  || Auth::user()->name == 'SpecialCurator' || Auth::user()->name == 'Koalra' ) {
                
                return $next($request);
            }

            return redirect()->route('underconstruct');
        }

        return $next($request);
    }
}
