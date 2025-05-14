<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\SpotifyTrack;
use App\Models\SpotifyToken;

class SpotifyPlaylistController extends Controller
{

    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;

    public function __construct()
    {
        $this->client_id = env('SPOTIFY_CLIENT_ID');
        $this->client_secret = env('SPOTIFY_CLIENT_SECRET');
        $this->redirect_uri = route('spotify.callback');
    }

    public function login()
    {
        
        // Define the Spotify OAuth URL
        $scopes = 'user-read-private user-read-email playlist-modify-public playlist-modify-private';

        $query = http_build_query([
            'client_id' => $this->client_id,
            'response_type' => 'code',
            'redirect_uri' => $this->redirect_uri,
            'scope' => $scopes,
            'show_dialog' => true,  // This will always show the login dialog to allow switching accounts
        ]);

        return redirect("https://accounts.spotify.com/authorize?" . $query);
    }

    public function callback(Request $request)
    {
        // Get Spotify tokens from the API response
        $tokenResponse = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => $this->redirect_uri,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
        ]);

        // Check if the request was successful
        if ($tokenResponse->successful()) {
            $tokens = $tokenResponse->json();
            $accessToken = $tokens['access_token'];
            $refreshToken = $tokens['refresh_token'];
            $expiresIn = $tokens['expires_in'];

            // Calculate when the token expires
            $expiresAt = now()->addSeconds($expiresIn);

            // Get the authenticated Laravel user
            $user = Auth::user();

            // Store the tokens in the database
            SpotifyToken::updateOrCreate(
                ['user_id' => $user->id], // Ensure one record per user
                [
                    'access_token' => $accessToken,
                    'refresh_token' => $refreshToken,
                    'expires_at' => $expiresAt
                ]
            );
            
            // Redirect or do any other action after successful login
            return redirect()->route('spotify.playlists')->with('success', 'Successfully logged in with Spotify!');
        }

        return redirect()->route('spotify.login')->withErrors('Failed to authenticate with Spotify.');
    }

    public function getPlaylists()
    {

        // Get the currently authenticated user
        $user = Auth::user();

        // Get the user's Spotify tokens from the database
        $spotifyToken = SpotifyToken::where('user_id', $user->id)->first();

        if (!$spotifyToken) {
            return redirect()->route('spotify.login')->withErrors('Please log in with Spotify first.');
        }

        // Check if the token has expired and refresh it if needed
        if ($spotifyToken->expires_at < now()) {
            $this->refreshTokenIfNeeded();
        }
        // Use the access token to fetch playlists
        $response = Http::withToken($spotifyToken->access_token)
            ->get('https://api.spotify.com/v1/me/playlists');

        if ($response->successful()) {
            $playlists = $response->json();
            return view('curator.playlist.index', [
                'playlists' => $playlists['items'],
            ]);
        }

        return back()->withErrors('Failed to fetch playlists.');
    }

    protected function refreshTokenIfNeeded()
    {
        $spotifyToken = SpotifyToken::where('user_id', auth()->id())->first();

        if ($spotifyToken && $spotifyToken->expires_at < now()) {
            // Make a request to refresh the token
            $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $spotifyToken->refresh_token,
                'client_id' => config('services.spotify.client_id'),
                'client_secret' => config('services.spotify.client_secret'),
            ]);

            if ($response->successful()) {
                $tokens = $response->json();
                $accessToken = $tokens['access_token'];

                // Update the access token in the database
                $spotifyToken->update(['access_token' => $accessToken, 'expires_at' => now()->addSeconds($tokens['expires_in'])]);
                return $accessToken;
            } else {
                // Handle refresh token failure
                return null;
            }
        }

        return $spotifyToken->access_token ?? null;
    }

    // Get a specific Spotify playlist by ID
    public function getPlaylist($id)
    {
        $user = Auth::user();
        $offer = $user->offer;
        
    
        foreach ($offer as $offers) {
            if ($offers->music) {
                $offerMusic[] = [$offers->music->title, $offers->music->id];
            }
            
        }

        // Refresh the access token if needed
        $accessToken = $this->refreshTokenIfNeeded();

        // If the token is not available, redirect to the login page
        if (!$accessToken) {
            return redirect()->route('spotify.login');
        }

        // Make a request to Spotify API to get the playlist details
        $response = Http::withToken($accessToken)->get("https://api.spotify.com/v1/playlists/$id");

        // If the request fails, handle the error (e.g., token expired, playlist not found, etc.)
        if ($response->failed()) {
            return redirect()->route('spotify.playlists')->withErrors('Failed to fetch playlist details.');
        }

        // Get the playlist data from the response
        $playlist = $response->json();

        // Pass the playlist data to the Blade view
        return view('curator.playlist.show', [
            'playlist' => $playlist,
            'offersMusic' => $offerMusic,
        ]);
    }

    public function logout()
    {
        // Forget the session data for Spotify
        session()->forget('spotify_access_token');

        // Optionally, you can also forget the Spotify refresh token and user info if stored
        session()->forget('spotify_refresh_token');
        session()->forget('spotify_user');

        // Redirect the user back to your homepage or login page
        return redirect('/')->with('success', 'Successfully logged out of Spotify.');
    }

    public function addTrack(Request $request){

        $validated= $request->validate([
            'musicName' => 'required',
            'pos' => 'required',
            'days' => 'required',
        ]);

        $trackId = $validated['musicName'];
        $position = $validated['pos'] - 1;
        $playlist = $request->playlistId;

        $request->musicOffer != null ? $request->musicOffer : null;

        //date convert
        $currentDate = Carbon::now();
        $expirationDate = $currentDate->addDays(intval($validated['days']));
        
        $user = Auth::user();
        $spotifyToken = SpotifyToken::where('user_id', $user->id)->first();

        if (!$spotifyToken) {
            return redirect()->route('spotify.login')->withErrors('Please log in with Spotify first.');
        }

        // Refresh the token if it has expired
        if ($spotifyToken->expires_at < now()) {
            $this->refreshTokenIfNeeded();
        }
        
        // Define the Spotify API endpoint for adding tracks to a playlist
        $url = "https://api.spotify.com/v1/playlists/{$playlist}/tracks";

        // Prepare the data to be sent to the Spotify API
        $data = [
            'uris' => ["$trackId"], // Track URI
            'position' => $position // The position of the track in the playlist
        ];

        // Send a POST request to the Spotify API to add the track
        $response = Http::withToken($spotifyToken->access_token)->post($url, $data);


        if ($response->successful()) {
            // Schedule the track removal if expiration date is set
            if ($expirationDate) { 
                // $this->scheduleTrackRemoval($trackId, $playlistId, $expirationDate);
                
                SpotifyTrack::create([
                    'spotify_token_id' => $spotifyToken->id,
                    'track_id' => $trackId,
                    'playlist_id' => $playlist,
                    'expiration_date' => $expirationDate,
                    'status' => true, //added
                    'music_id' => $request->musicOffer,
                      
                ]);
            }

            return back()->with('success', 'Track added successfully!');
        }

        return back()->withErrors('Failed to add track.');
    
    }
    
}
