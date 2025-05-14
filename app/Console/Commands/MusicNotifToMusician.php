<?php

namespace App\Console\Commands;

use App\Mail\MusicNotifToMusician as MailMusicNotifToMusician;
use App\Models\Offer;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Services\EmailService;


class MusicNotifToMusician extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:music-notif-musician';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $offer = Offer::all();
        $sevenDaysAgo = Carbon::now()->subDays(7);
        

        foreach ($offer as $offers) {
            $musicTitle = $offers->music->title;
            $artist = $offers->music->artist->name;
            $emails = $offers->music->artist->email;
            if (!$offers->accepted_at) {
                
                if ($offers->created_at == $sevenDaysAgo) {
                    $emailService = app(EmailService::class);
                    $user = $offers->music->artist;
                    $emailService->send(
                        $emails, 
                        (new MailMusicNotifToMusician($musicTitle, $artist))->forUser($user), 
                        'music.notification', 
                        $user
                    );
                    // echo $musicTitle . "\n";
                }
            }
        }
    }
}
