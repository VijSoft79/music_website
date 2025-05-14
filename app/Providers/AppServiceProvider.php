<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// use App\Services\EmailPreferenceService;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\EmailToArtistRegister;
use App\Mail\RegisterConfirm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TrackCampaignMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->singleton(EmailPreferenceService::class, function ($app) {
        //     return new EmailPreferenceService();
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the campaign tracking middleware for all web routes
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', TrackCampaignMiddleware::class);

        // VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        //     $userRole = $notifiable->getRoleNames()->first();
            
        //     if ($userRole === 'curator') {
        //         return new RegisterConfirm($notifiable->name ,$url, $notifiable->email);
        //     } elseif ($userRole === 'musician') {
        //         return new EmailToArtistRegister($url, $notifiable->email);
        //     } else {

        //         return (new MailMessage)
        //             ->subject('Welcome to You Hear Us')
        //             ->line('Thank you for registering. Please verify your email address.')
        //             ->action('Verify Email Address', $url);
        //     }

        // });
    }
}
