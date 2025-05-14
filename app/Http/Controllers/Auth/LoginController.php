<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use Spatie\Permission\Traits\HasRoles;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // $validate = $request->validate([
        //     'g-recaptcha-response' => 'required',
        // ]);
        
        // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'secret' => config('services.recaptcha.secret_key'),
        //     'response' => $request->input('g-recaptcha-response'),
        //     'remoteip' => $request->ip(),
        // ]);
        // $responseData = $response->json();

        // if (!$responseData['success'] || $responseData['score'] < 0.5) {
        //     return back()->withErrors(['captcha' => 'reCAPTCHA validation failed.']);
        // }

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->hasRole('curator')) {

                return redirect()->route('curator.home');

            } elseif ($user->hasRole('musician')) {

                return redirect()->intended(route('musician.index'));

            } elseif ($user->hasRole('administrator')) {

                return redirect()->route('admin.home');

            } elseif ($user->hasRole('writer')) {

                return redirect()->route('writer.index');

            } else {

                return Redirect::back()->withErrors(['message' => 'You are not authorized.']);
            }
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }
}
