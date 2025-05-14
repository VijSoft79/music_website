<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AdminSetting;
use App\Models\Campaign;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterConfirm;
use App\Mail\EmailToArtistRegister;
use App\Mail\EmailToadminWhenMusicianRegister;
use App\Mail\RegistrationNotifToadmin;
use Closure;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Auth\Events\Registered;

use App\Models\CuratorWallet;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public $emailToadmin;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    // public $messageContent = "thanks For registering";

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest')->only('methodForGuests');
        $this->middleware('administrator')->only('methodForAdmins');
        $this->emailService = app(EmailService::class);
    }

    // Add protected property for emailService
    protected $emailService;

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_role' => ['required'],
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'contact' => ['required', 'number'],
            'website' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'] ?? null,
            'band_name' => $data['band_name'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole($data['user_role']);

        return $user;
    }

    protected function adminregisterAccount(Request $request){
        $data = $request->validate([
            'user_role' => ['required'],
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if($data['user_role'] == 'writer'){
            $user = $this->create($data);
            return redirect()->route('admin.writers.index')->with('message', 'Writer created successfully');
        }

    }

    public function register(Request $request)
    {
        // Validate the user's registration data
        $adminSettings = AdminSetting::where('name', 'autoApproveMusician')->first();
        $data = $request->validate([
            'user_role' => ['required'],
            'band_name' => ['sometimes','required', 'string', 'max:30'],
            'name' => ['sometimes', 'required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'page-token' => ['required'],
            'g-recaptcha-response' => ['required'],
        ]);

        // recaptcha
        $g_response = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => '6LewNd0qAAAAAB6bLdtdCzhlvljbRiQVjAGslo4l',
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$g_response->json('success')) {
            return back()->withErrors(['g-recaptcha-response' => 'Invalid reCAPTCHA verification.']);
        }

        if($data['user_role'] == 'writer'){
            $user = $this->create($data);
            return redirect()->route('admin.writers.index');
        }

        // Create a new user
        $user = $this->create($data);

        // event(new Registered($user));
     
            
        if ($request->contact) {
            $user->phone_number = $request->contact;
        }

        if ($request->website) {
            $user->website = $request->website;
        }

        //admin global settings
        if ($data['user_role'] == 'musician') {
            $user->is_approve = $adminSettings->status == 1 ? 1 : 0;
        }
        
        //default location
        $user->location = 'Canada';
        $user->save();

        // Track campaign registration if a campaign slug is stored in the session
        if (session()->has('campaign_slug')) {
            $campaignSlug = session('campaign_slug');
            $campaign = Campaign::where('slug', $campaignSlug)->first();
            
            if ($campaign) {
                $campaign->increment('registrations');
            }
            
            // Clear the campaign from session after tracking
            session()->forget('campaign_slug');
        }

        Auth::login($user);

        // Clear Spatie permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create curators wallet
        if ($data['user_role'] == 'curator') {
            CuratorWallet::create([
                'curator_id' => $user->id,
                'amount' => 0
            ]);
        } 

        if($data['user_role'] == 'curator'){
            $this->emailService->send('admin@youhearus.com', new RegistrationNotifToadmin($data['name']), 'registration.notification', null);
            $this->emailService->send($user->email, (new RegisterConfirm($user->name))->forUser($user), 'registration.confirmation', $user);
        }else{
            $this->emailService->send('admin@youhearus.com', new EmailToadminWhenMusicianRegister($user->name ?? $user->band_name), 'registration.notification', null);
            $this->emailService->send($user->email, (new EmailToArtistRegister($user->name ?? $user->band_name))->forUser($user), 'registration.confirmation', $user);
        }
        

        // Reload user model and check roles for redirection
        $user = $user->fresh();

        if ($user->hasRole('curator')) {
            return redirect()->route('curator.home');
        } elseif ($user->hasRole('musician')) {
            return redirect()->route('musician.index');
        } else {
            Log::error('User registered but role check failed after registration.', [
                'user_id' => $user->id, 
                'assigned_role' => $data['user_role'],
                'detected_roles' => $user->getRoleNames()
            ]);
            return redirect('/login')->with('error', 'Registration successful, but there was an issue accessing your dashboard. Please try logging in again or contact support.');
        }
    }

    public function googleLogin(){
        return Socialite::driver('google')->redirect();
    }
}
